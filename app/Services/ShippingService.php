<?php
namespace App\Services;

use App\Mail\ShippingReportMail;
use Illuminate\Support\Facades\{Mail, Response, Auth};
use App\Models\{User, Shipment, Country, Address, Parcel, Item, Attachment, Transaction,};
use Illuminate\Http\Request;
use App\Util\{Logistics, ResponseFormatter};
use Carbon\Carbon;

class ShippingService
{  
    // private Logistics $logistics;

    // public function __construct(Logistics $logistics)
    // {
    //     $this->logistics = $logistics;
    // }

    public static function reportShippingUpdate($mail_data){
        Mail::to(env("SHIPPING_REPORT_MAIL"))->send(new ShippingReportMail($mail_data));
        // Mail::to([env("SHIPPING_REPORT_MAIL"), env("ADMIN_MAIL")])->send(new ShippingReportMail($mail_data));
    }

    public static function showShippingForm(Request $request)
    {   
        
        $slug = $request->slug;
        $shipment = Shipment::with('address_from', 'address_to')
        ->with(['parcels' => function ($query) {
            $query->with(['items', 'attachments']); 
        }])->where("slug", $slug)->first();
        // dd($shipment);
       
        $fromStates = $shipment?->address_from?->nation()?->first()->states;
        
        $toStates = $shipment?->address_to?->nation()?->first()->states;
       
        $fromCities = $shipment?->address_from?->hostState()?->first()->cities;
        
        $toCities = $shipment?->address_to?->hostState()?->first()->cities;

        $parcels = json_encode($shipment->parcels);
       
        $user = User::find(Auth::user()->id);
       
        $countries = Country::all();

        $logistics = new Logistics();
        $response = $logistics->getChapters();
        $response = json_decode($response);
        $chapters = $response->data;

        $states = [
            "from" => $fromStates,
            "to" => $toStates
        ];
        // dd($states);

        $cities = [
            "from" => $fromCities,
            "to" => $toCities
        ];

        return view('customer.shippings.create-shipping', compact(
            'user', 'shipment', 'countries', 
            'chapters', 'states', 
            'cities', 'slug', 'parcels'
        ));
    }

    public static function saveShipment(Request $request){
        $user = User::find(Auth::user()->id);
        $shipment = new Shipment;
        $shipment->user_id = $user->id;
        $shipment->title = sanitize_input($request->title);
        $shipment->slug = slugify($shipment->title);
        $shipment->save();
        return redirect()->route('edit-shipment', $shipment->slug);
    }

    public static function saveAddress(Request $request){
        // dd(Auth::user()->id);
        $shipment = Shipment::where(['slug'=>sanitize_input($request->slug), 'user_id'=>Auth::user()->id])
       ->with('address_from', 'address_to')
        ->with(['parcels' => function ($query) {
            $query->with(['items', 'attachments']); 
        }])
        ->first();

        if($shipment){
            $type_match = [
                "sender" => "from",
                "receiver"=>"to"
            ];
            $address = $shipment->address()->where('type', $type_match[$request->type])->first();

            if(!$address){
                $address = new Address();
            }
            
            $address->firstname = sanitize_input($request->firstname);
            $address->lastname = sanitize_input($request->lastname);
            $address->email = sanitize_input($request->email);
            $address->phone = sanitize_input($request->phone);
            $address->country = sanitize_input($request->country);
            $address->state = sanitize_input($request->state);
            $address->city = sanitize_input($request->city);
            $address->zip = sanitize_input($request->zip);
            $address->line1 = sanitize_input($request->line1);
            if($request->type == 'sender'){
                $address->type = 'from';
            }elseif($request->type == 'receiver'){
                $address->type = 'to';
            }
            $address->shipment_id = $shipment->id;
            $address->save(); 

            return Response::json([
                'status'    => 'success',
                'message'   => 'Address saved',
            ], 200);
        }

        return Response::json([
            'status'    => 'fail',
            'error'   => 'Shipment Not Found',
        ], 404);
    }

    public static function saveParcel(Request $request){
        // dd($request)->all();
        $parcel = new Parcel();
        $parcel->shipment_id = sanitize_input($request->shipment_id);
        $parcel->external_parcel_id = sanitize_input($request->external_parcel_id);
        $parcel->metadata = sanitize_input($request->metadata);
        $parcel->weight = sanitize_input($request->weight);
        
        if($request->weight_unit != ""){
            $parcel->weight_unit = sanitize_input($request->weight_unit);
        }

        $parcel->save();

        return Response::json([
            'status'    => 'success',
            'parcel'   => $parcel,
            'shipment' => Shipment::where(['id'=>$parcel->shipment_id, 'user_id'=>Auth::user()->id])->with('address_from', 'address_to')
            ->with(['parcels' => function ($query) {
                $query->with(['items', 'attachments']); 
            }])->first(),
        ], 201);
    }

    public static function saveItem(Request $request){
        // dd($request->all());
        if($request->id){
            $newItem = Item::where('id', sanitize_input($request->id))
            ->whereHas('shipment', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->first();
        }else{
            $newItem = new Item;
            $newItem->parcel_id = sanitize_input($request->parcel_id);
            $newItem->shipment_id = sanitize_input($request->shipment_id);
            //$newItem->description = sanitize_input($request->description);
        }
        
        $newItem->name = sanitize_input($request->name);
        $newItem->currency = sanitize_input($request->currency);
        $newItem->value = sanitize_input($request->value);
        $newItem->quantity = sanitize_input($request->quantity);
        $newItem->weight = sanitize_input($request->weight);
        $newItem->category = sanitize_input($request->category);
        $newItem->sub_category = sanitize_input($request->sub_category);
        $newItem->hs_code = sanitize_input($request->hs_code);
        $newItem->description = sanitize_input($request->description);
        $newItem->save();
        
        return Response::json([
            'status'    => 'success',
            'item'   => $newItem,
            'shipment' => Shipment::where(['id'=>$newItem->shipment_id, 'user_id'=>Auth::user()->id])->with('address_from', 'address_to')
            ->with(['parcels' => function ($query) {
                $query->with(['items', 'attachments']); 
            }])->first(),
        ], 201);

        
        
    }

    public static function getUserShipments(Request $request)
    {
        $shipments = Shipment::where('user_id', Auth::user()->id)->with('address_from', 'address_to')
        ->with(['parcels' => function ($query) {
            $query->with(['items', 'attachments']); 
        }]);
        // Filter transactions by period
        if ($request->has('period')):
            switch($request->period):
                case "today":
                    $shipments = $shipments->whereDate('created_at', Carbon::today())
                    ->orderByDesc("created_at");
                break;
                case "week":
                    $shipments = $shipments->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->orderByDesc("created_at");
                break;
                case "month":
                    $shipments = $shipments->whereMonth('created_at', Carbon::now()->month)
                    ->orderByDesc("created_at");
                break;
                case "year":
                    $shipments = $shipments->whereYear('created_at', Carbon::now()->year)
                    ->orderByDesc("created_at");
                break;
            endswitch;
        else:
            $shipments = $shipments->orderByDesc("created_at");
        endif;

        return ResponseFormatter::success("Shipments:", $shipments->get(), 200);
    }

    public static function getShipment(string $id){
        return Response::json([
            'status'    => 'success',
            'shipment'   => Shipment::where(['id'=>$id, 'user_id'=>Auth::user()->id])->with('address_from', 'address_to')
            ->with(['parcels' => function ($query) {
                $query->with(['items', 'attachments']); 
            }])->first(),
        ], 200);
    }

    public static function deleteItem($id){
        $item = Item::where('id', sanitize_input($id))
        ->whereHas('shipment', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->first();

        $other_items_count = Item::where('parcel_id', $item->parcel->id)->count();

        if($other_items_count == 0){
           return self::deleteParcel($item->parcel->id);
        }
        $item ->delete();
        return Response::json([
            'status'    => 'success',
            'message'   => 'item successfully deleted'
        ], 200);
    }

    public static function deleteParcel($parcel_id){
        Item::where('parcel_id', $parcel_id)->delete();
        Parcel::where('id', $parcel_id)->delete();
        return Response::json([
            'status'    => 'success',
            'message'   => 'Parcel successfully deleted'
        ], 200);
        
    }

    public static function uploadParcelDocument(Request $request) {
        $files = $request->file("attachments");
        foreach ($files as $file) {
            $url = cloudinary()->upload($file->getRealPath())->getPath();
            // ->getSecurePath();
            $attachment = new Attachment();
            $attachment->file = $url;
            $attachment->parcel_id = sanitize_input($request->parcel_id);
            $attachment->type = sanitize_input($request->type);
            $attachment->save();
        }
        return Response::json([
            'status'    => 'success',
            'message'   => 'file uploaded',
            'shipment' => $attachment->parcel->shipment()->with('address_from', 'address_to')
            ->with(['parcels' => function ($query) {
                $query->with(['items', 'attachments']); 
            }])->first(),
        ], 200);
    }

    public static function getCarriers(string $id){
       $shipment = Shipment::with('address_from', 'address_to')
       ->with(['parcels' => function ($query) {
           $query->with(['items', 'attachments']); 
       }])->where("id", $id)->first();

       $logistics = new Logistics();

       $address_from = $logistics->createAddress($shipment->address_from);
       $address_from = json_decode($address_from, true);

       $address_to = $logistics->createAddress($shipment->address_to);
       $address_to = json_decode($address_to, true);

        $shipmentArray = $shipment->toArray();
        $parcels = [];
        $keys1 = ['id', 'shipment_id', 'external_parcel_id', 'weight', 'weight_unit', 'metadata', 'attachments'];
        $keys2 = ['id', 'category', 'parcel_id', 'sub_category', 'shipment_id']; // Assuming you want to remove keys from items as well
        $attachments = [];
        foreach ($shipmentArray['parcels'] as &$parcel) :
            $parcel["docs"] = [];
            // Remove keys from parcel array
            foreach ($keys1 as $key):
                if (array_key_exists($key, $parcel)) {
                    unset($parcel[$key]);
                }
            endforeach;
            $parcel["description"] = "white coloured wrapped with a cellophane paper";
            // Remove keys from items within each parcel
     
            foreach ($parcel['items'] as &$item) :
                $item['description'] = 'Shoes purchased from Shipmonk Store';
                foreach ($keys2 as $key) {
                    if (array_key_exists($key, $item)) {
                        unset($item[$key]);
                    }
                }
                // Convert value to integer
                $item['value'] = (int) $item['value'];
                $item['weight'] = (float) $item['weight'];
                $item['type'] = "parcel";
            endforeach;

            $parcell = $logistics->createParcel([
                "description" => $parcel["description"],
                "items" => $parcel["items"],
                "docs" => $parcel["docs"]
            ]);
            $parcell = json_decode($parcell);
            $parcell = $parcell->data;
            array_push($parcels, $parcell);
        endforeach;

        $newShipment = $logistics->createShipment([
            "parcels" => array_column($parcels, "parcel_id"),
            'address_from' => $address_from['data']["address_id"],
            'address_to' => $address_to['data']["address_id"]
        ]);
        $newShipment = json_decode($newShipment);
        $newShipment = $newShipment->data;
        $shipment->external_shipment_id = $newShipment->shipment_id;
        $shipment->save();
        
        //get Rates for Shipment
        $rates = $logistics->getRateForShipment([
            "shipment_id" => $newShipment->shipment_id,
            'address_from' => $address_from['data']["address_id"],
            'address_to' => $address_to['data']["address_id"]
        ]);
        $rates = json_decode($rates);
        $rates = $rates->data;

        $data = [
            "parcels" => $parcels,
            "rates" => $rates
        ];

        return Response::json([
            'status' => 'success',
            'message' => 'Carriers successfully fetched',
            'results' => $data
        ], 200);
    }


    public static function makePayment(Request $request)
    {
        
        $user = User::find(Auth::user()->id);
        $shipment = Shipment::where(["id" => sanitize_input($request->shipment_id), 'user_id'=>$user->id])->first();
        if(!$shipment){
            return ResponseFormatter::error("Shipment not found", 404);
        }
        $wallet = $user->wallet;
        if($wallet->balance <= $request->total):
            return ResponseFormatter::error("Insufficient wallet balance...", null, 400);
        endif;

        $wallet->balance -= $request->total;

        $transaction = new Transaction();
        $transaction->wallet_id = $wallet->id;
        $transaction->amount = $request->total;
        $transaction->type = "Debit";
        $transaction->purpose = "Payment for ".$request->shipment_id." shipment";
        $transaction->reference = generateReference($wallet->id);
        $transaction->status = "success";
        $transaction->verified = true;

        $payload = [
            'rate_id' => $request->rate_id
            //'shipment_id' => $request->shipment_id, //optional
        ];
        //Arrange pickup for shipment
        $logistics = new Logistics();
        $pickup = $logistics->arrangePickup($payload);
        $pickup = json_decode($pickup);
       
        
        if(!$pickup->status):
            return ResponseFormatter::error("Oops!! ".$pickup?->message, 400, $pickup);
        else:
            $statuses = ["confirmed", "in-transit"];
            if(in_array($pickup->data->status, $statuses)):
                $wallet->save();
                $transaction->save();

                $response = $logistics->getShipment($shipment->external_shipment_id);
                $response = json_decode($response);
                $data = $response->data;

                
                $shipment->status = $pickup->data->status;
                $shipment->pickup_date = $data->pickup_date;
                $shipment->save();
            endif;
        endif;
        return Response::json([
            'status' => 'success',
            'message' => 'Shipment arranged successfully',
            'results' => $data
        ], 200);
    }
}