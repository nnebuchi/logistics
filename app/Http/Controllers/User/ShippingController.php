<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\{
    Shipment,
    Address,
    Item,
    Transaction,
    Parcel
};
use App\Util\ResponseFormatter;
use App\Util\Logistics;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Exception;
use App\Models\WebhookLog;
use App\Notifications\SendInvoice;
use App\Services\ShippingService;

class ShippingController extends Controller
{
    private Logistics $logistics;

    public function __construct(Logistics $logistics)
    {
        $this->logistics = $logistics;
    }

    private function generateReference($id)
    {
        $token = "";
        $codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codeAlphabet .= 'abcdefghijklmnopqrstuvwxyz';
        $codeAlphabet .= '0123456789';
        $max = strlen($codeAlphabet) - 1;
        for($i=0; $i<14; $i++):
            $token .= $codeAlphabet[mt_rand(0, $max)]; 
        endfor; 
        return $id.strtolower($token);
    }

    public function showShippings()
    {
        $user = User::find(Auth::user()->id);
        $stats = [
            "cancelled" => $user->shipments()->where('status', "cancelled")->count(),
            "in-transit" => $user->shipments()->where('status', "in-transit")->count(),
            "delivered" => $user->shipments()->where('status', "delivered")->count(),
            "total" => $user->shipments()->count()
        ];

        return view('customer.shippings.shipping', compact('user', 'stats'));
    }

    public function editShipping($shipmentId)
    {
        $user = User::find(Auth::user()->id);
        if($user->is_verified):
            $shipment = Shipment::where("external_shipment_id", $shipmentId)->first();
            $countries = Country::all();

            $fromCountry = Country::where("sortname", $shipment->address_from->country)->first();
            $toCountry = Country::where("sortname", $shipment->address_to->country)->first();
            $fromState = State::where("name", $shipment->address_from->state)->first();
            $toState = State::where("name", $shipment->address_to->state)->first();

            $fromStates = State::where("country_id", $fromCountry->id)->get();
            $toStates = State::where("country_id", $toCountry->id)->get();
            $fromCities = City::where("state_id", $fromState->id)->get();
            $toCities = City::where("state_id", $toState->id)->get();

            $response = $this->logistics->getChapters();
            $response = json_decode($response);
            $chapters = $response->data;

            $states = [
                "from" => $fromStates,
                "to" => $toStates
            ];

            $cities = [
                "from" => $fromCities,
                "to" => $toCities
            ];

            return view(
                'customer.shippings.edit-shipping', 
                compact('user', 'shipment', 'countries', 'chapters', 'states', 'cities')
            );
        endif;
    }

    public function getUserShipments(Request $request)
    {
        $user = User::find(Auth::user()->id);

        // Filter transactions by period
        if ($request->has('period')):
            switch($request->period):
                case "today":
                    $shipments = $user->shipments()
                    ->whereDate('created_at', Carbon::today())
                    ->orderByDesc("created_at")
                    ->get();
                break;
                case "week":
                    $shipments = $user->shipments()
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->orderByDesc("created_at")
                    ->get();
                break;
                case "month":
                    $shipments = $user->shipments()
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->orderByDesc("created_at")
                    ->get();
                break;
                case "year":
                    $shipments = $user->shipments()
                    ->whereYear('created_at', Carbon::now()->year)
                    ->orderByDesc("created_at")
                    ->get();
                break;
            endswitch;
        else:
            $shipments = $user->shipments()->orderByDesc("created_at")->get();
        endif;

        return ResponseFormatter::success("Shipments:", $shipments, 200);
    }

    public function showShippingForm()
    {
        $user = User::find(Auth::user()->id);
        if($user->is_verified):
            $countries = Country::all();

            $response = $this->logistics->getChapters();
            $response = json_decode($response);
            $chapters = $response->data;

            return view('customer.shippings.create-shipping', compact('user', 'countries', 'chapters'));
        endif;
    }

    public static function getStates(int $countryId)
    {
        $states = State::where(['country_id' => $countryId])->get();

        return ResponseFormatter::success("States:", $states, 200);
    }
    
    public static function getCities(int $stateId)
    {
        $cities = City::where(['state_id' => $stateId])->get();
            
        return ResponseFormatter::success("Cities:", $cities, 200);
    }

    public function shipmentWebhook(Request $request)
    {
        
        try{

            WebhookLog::create([
                'event' => $request['event'],
                'payload' => json_encode($request->all())
            ]);
            // dd($request["event"]);
            $id = $request["data"]["shipment_id"];
            $shipment = Shipment::where(['external_shipment_id' => $id ])->first();
            
            switch($request["event"]):
                case "shipment.confirmed":
                    //Handle shipment confirmed event
                    $status = "confirmed";
                    $shipment->status = $status;
                break;
                case "shipment.in-transit":
                    //Handle shipment in-transit event
                    $status = "in-transit";
                    $shipment->status = $status;
                break;

                case "shipment.delivered":
                    //Handle shipment delivered update event
                    $status = "delivered";
                    $shipment->status = $status;
                break;
                case "shipment.cancelled":
                    //Handle shipment cancelled update event
                    $status = "cancelled";
                    $shipment->status = $status;
                break;
                default:
                   return;
            endswitch;
            $shipment->pickup_date = $request["data"]["pickup_date"];
            $shipment->save();

            ShippingService::reportShippingUpdate([
                'type'=>'success', 
                'event' => $status,
                'data' => $request->all()
            ]);
            http_response_code(200);
        }catch (Exception $e) {
            // Log the error
            WebhookLog::create([
                'event' => $request['event'],
                'payload' => json_encode($request->all()),
                'error_message' => $e->getMessage()
            ]);

            ShippingService::reportShippingUpdate(['type'=>'error', 'data'=>$e]);
            http_response_code(400);
        }
    }   

    public static function showTrackingForm()
    {
        $user = User::find(Auth::user()->id);

        return view('customer.shippings.tracking', compact('user'));
    }

    public function makePayment(Request $request)
    {
        
        $user = User::find(Auth::user()->id);
        $wallet = $user->wallet;
        if($wallet->balance <= $request->total):
            return ResponseFormatter::success("Insufficient wallet balance...", null, 400);
        endif;

        $wallet->balance -= $request->total;

        $transaction = new Transaction();
        $transaction->wallet_id = $wallet->id;
        $transaction->amount = $request->total;
        $transaction->type = "Debit";
        $transaction->purpose = "Payment for ".$request->shipment_id." shipment";
        $transaction->reference = $this->generateReference($wallet->id);
        $transaction->status = "success";
        $transaction->verified = true;

        $payload = [
            'rate_id' => $request->rate_id
            //'shipment_id' => $request->shipment_id, //optional
        ];
        //Arrange pickup for shipment
        $pickup = $this->logistics->arrangePickup($payload);
        $pickup = json_decode($pickup);
       
        
        if(!$pickup->status):
            return ResponseFormatter::error("Oops!! ".$pickup?->message, 400, $pickup);
        else:
            $statuses = ["confirmed", "in-transit"];
            if(in_array($pickup->data->status, $statuses)):
                $wallet->save();
                $transaction->save();

                $response = $this->logistics->getShipment($request->shipment_id);
                $response = json_decode($response);
                $data = $response->data;

                $shipment = Shipment::where("external_shipment_id", $request->shipment_id)->first();
                $shipment->status = $pickup->data->status;
                $shipment->pickup_date = $data->pickup_date;
                $shipment->save();

                /*if($data->extras):
                    $notificationData = [
                        "subject" => "Customer Invoice & Waybill",
                        "title" => "Ziga Afrika Invoice & Waybill",
                        "message" => "Customer invoice and waybill details",
                        "attachment1" => $data->extras->commercial_invoice_url,
                        "attachment2" => $data->extras->shipping_label_url
                    ];
                    $user->notify(new SendInvoice($notificationData));
                endif;*/
            endif;
        endif;

        return ResponseFormatter::success("Shipment arranged successfully", null, 200);
    }

    public function createParcel($items, $description)
    {
        $parcels = [];
        foreach($items as $item):
            $parcel = $this->logistics->createParcel([
                "description" => $description,
                "items" => $item["items"],
                "docs" => array_column($item["docs"], 'photo'),
                //"metadata" => $item["docs"]
            ]);
            $parcel = json_decode($parcel);
            $parcel = $parcel->data;
            array_push($parcels, $parcel);
        endforeach;
        return $parcels;
    }

    public function createShipment(Request $request){
        $user = User::find(Auth::user()->id);

        /*$payload = [
            "address_from"=> "AD-9GXPHFVGFKY1PPXJ",
            "address_to"=> "AD-8N1HQ62VRE7IB9XH",
            "description"=> "white paper",
            "items"=> [
                [
                        "items" => [
                            [
                            "name"=> "Books",
                            "description"=> "white coloured wrapped with a cellophane paper",
                            "type"=> "parcel",
                            "currency"=> "NGN",
                            "value"=> 125.50,
                            "quantity"=> 2,
                            "weight"=> 1,
                            "hs_code"=> "071290"
                        ]
                    ]
                ],
                [
                        "items" => [
                            [
                            "name"=> "Books",
                            "description"=> "white coloured wrapped with a cellophane paper",
                            "type"=> "parcel",
                            "currency"=> "NGN",
                            "value"=> 125.50,
                            "quantity"=> 2,
                            "weight"=> 1,
                            "hs_code"=> "071290"
                        ]
                    ]
                ],
            ],
            //"shipment_id" => "SH-SK52SQLQEC38EE36"
        ];
        $request = new Request();
        $request->merge($payload);*/

        //Create parcel
        $parcels = $this->createParcel($request->items, $request->description);

        if($request->has("shipment_id")):
            $shipment = $this->logistics->updateShipment($request->shipment_id, [
                "parcels" => array_column($parcels, "parcel_id"),
                'address_from' => $request->address_from,
                'address_to' => $request->address_to
            ]);
            $shipment = json_decode($shipment);
            $shipment = $shipment->data;
            $this->editShipment($shipment);
        else:
            $shipment = $this->logistics->createShipment([
                "parcels" => array_column($parcels, "parcel_id"),
                'address_from' => $request->address_from,
                'address_to' => $request->address_to
            ]);
            $shipment = json_decode($shipment);
            $shipment = $shipment->data;
            $this->saveShipment($shipment, $user);
        endif;

        //get Rates for Shipment
        $rates = $this->logistics->getRateForShipment([
            "shipment_id" => $shipment->shipment_id,
            'address_from' => $request->address_from,
            'address_to' => $request->address_to
        ]);
        $rates = json_decode($rates);
        $rates = $rates->data;

        $data = [
            "parcels" => $parcels,
            "shipment" => $shipment,
            "rates" => $rates
        ];
        return ResponseFormatter::success("Rates:", $data, 200);
    }

    public function saveShipment($data, User $user){
        $shipment = new Shipment;
        $shipment->user_id = $user->id;
        $shipment->external_shipment_id = $data->shipment_id;
        $shipment->pickup_date = $data->pickup_date;
        $shipment->save();

        foreach($data->parcels as $parcel):
            $newParcel = new Parcel;
            $newParcel->shipment_id = $shipment->id;
            $newParcel->external_parcel_id = $parcel->parcel_id;
            $newParcel->weight = $parcel->total_weight;
            $newParcel->weight_unit = $parcel->weight_unit;
            $newParcel->save();

            foreach($parcel->items as $item):
                $newItem = new Item;
                $newItem->shipment_id = $shipment->id;
                $newItem->parcel_id = $newParcel->id;
                $newItem->name = $item->name;
                $newItem->currency = $item->currency;
                $newItem->description = $item->description;
                $newItem->value = $item->value;
                $newItem->quantity = $item->quantity;
                $newItem->weight = $item->weight;
                $newItem->save();
            endforeach;
        endforeach;

        $from = new Address;
        $from->shipment_id = $shipment->id;
        $from->firstname = $data->address_from->first_name;
        $from->lastname = $data->address_from->last_name;
        $from->email = $data->address_from->email;
        $from->phone = $data->address_from->phone;
        $from->country = $data->address_from->country;
        $from->state = $data->address_from->state;
        $from->city = $data->address_from->city;
        $from->zip = $data->address_from->zip;
        $from->line1 = $data->address_from->line1;
        $from->type = "from";
        $from->save();

        $to = new Address;
        $to->shipment_id = $shipment->id;
        $to->firstname = $data->address_to->first_name;
        $to->lastname = $data->address_to->last_name;
        $to->email = $data->address_to->email;
        $to->phone = $data->address_to->phone;
        $to->country = $data->address_to->country;
        $to->state = $data->address_to->state;
        $to->city = $data->address_to->city;
        $to->zip = $data->address_to->zip;
        $to->line1 = $data->address_to->line1;
        $to->type = "to";
        $to->save();
    }

    public function editShipment($data){
        $shipment = Shipment::where("external_shipment_id", $data->shipment_id)->first();
        $shipment->parcels()->delete();
        $shipment->items()->delete();

        foreach($data->parcels as $parcel):
            $newParcel = new Parcel;
            $newParcel->shipment_id = $shipment->id;
            $newParcel->external_parcel_id = $parcel->parcel_id;
            $newParcel->weight = $parcel->total_weight;
            $newParcel->weight_unit = $parcel->weight_unit;
            $newParcel->save();

            foreach($parcel->items as $item):
                $newItem = new Item;
                $newItem->shipment_id = $shipment->id;
                $newItem->parcel_id = $newParcel->id;
                $newItem->name = $item->name;
                $newItem->currency = $item->currency;
                $newItem->description = $item->description;
                $newItem->value = $item->value;
                $newItem->quantity = $item->quantity;
                $newItem->weight = $item->weight;
                $newItem->save();
            endforeach;
        endforeach;

        $from = Address::where(["shipment_id" => $shipment->id, "type" => "from"])->first();
        $from->firstname = $data->address_from->first_name;
        $from->lastname = $data->address_from->last_name;
        $from->email = $data->address_from->email;
        $from->phone = $data->address_from->phone;
        $from->country = $data->address_from->country;
        $from->state = $data->address_from->state;
        $from->city = $data->address_from->city;
        $from->zip = $data->address_from->zip;
        $from->line1 = $data->address_from->line1;
        $from->type = "from";
        $from->save();

        $to = Address::where(["shipment_id" => $shipment->id, "type" => "to"])->first();;
        $to->firstname = $data->address_to->first_name;
        $to->lastname = $data->address_to->last_name;
        $to->email = $data->address_to->email;
        $to->phone = $data->address_to->phone;
        $to->country = $data->address_to->country;
        $to->state = $data->address_to->state;
        $to->city = $data->address_to->city;
        $to->zip = $data->address_to->zip;
        $to->line1 = $data->address_to->line1;
        $to->type = "to";
        $to->save();
    }

    public function trackShipment($shipmentId){
        $shipment = $this->logistics->trackShipment($shipmentId);
        $shipment = json_decode($shipment);
        $shipment = $shipment->data;

        $getShipping = Shipment::where("external_shipment_id", $shipmentId)->first();
        $shipment->items = $getShipping->items;

        return ResponseFormatter::success("Shipment fetched successfully:", $shipment, 200);
    }

    public function createAddress(Request $request){
        $address = $this->logistics->createAddress($request->all());
        $address = json_decode($address);
        if(!$address->status):
            return ResponseFormatter::error($address->message, 400);
        else:
            return ResponseFormatter::success($address->message, $address->data, 200);
        endif;
    }

    public function getCategories(Request $request)
    {
        $categories = $this->logistics->getCategories($request->chapter);
        $categories = json_decode($categories);

        return ResponseFormatter::success($categories->message, $categories->data, 200);
    }

    public function getHsCodes(Request $request)
    {
        $hs_codes = $this->logistics->getHsCodes($request->chapter, $request->category);
        $hs_codes = json_decode($hs_codes);

        return ResponseFormatter::success($hs_codes->message, $hs_codes->data, 200);
    }

    public function uploadParcelDocument(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf,docx|max:2048',
        ]);

        if($validator->fails()):
            return response([
                'message' => "Failed to update document",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        endif;

        if($request->hasFile("photo")):
            $photo = $request->file("photo");
            $url = cloudinary()->upload($photo->getRealPath())->getFileName();
        endif;

        return ResponseFormatter::success("Parcel doc uploaded successfully", ["photo" => $url], 200);
    }


}