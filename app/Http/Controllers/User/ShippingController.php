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
    Transaction
};
use App\Util\ResponseFormatter;
use App\Util\Logistics;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Exception;
use App\Models\WebhookLog;
use App\Notifications\SendInvoice;

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
        // Log the webhook payload
        WebhookLog::create([
            'event' => $request['event'],
            'payload' => json_encode($request->all())
        ]);

        try{
            $id = $request["data"]["id"] ?? $request["data"]["shipment_id"];
            $shipment = Shipment::where(['external_shipment_id' => $id ])->first();

            switch($request["event"]):
                case "shipment.in-transit":
                    //Handle shipment in-transit event
                    $shipment->status = "in-transit";
                break;
                case "shipment.delivered":
                    //Handle shipment delivered update event
                    $shipment->status = "delivered";
                break;
                case "shipment.cancelled":
                    //Handle shipment cancelled update event
                    $shipment->status = "cancelled";
                break;
                default:
                    //Handle unknown event received
            endswitch;
            $shipment->save();
            http_response_code(200);
        }catch (Exception $e) {
            // Log the error
            WebhookLog::create([
                'event' => $request['event'],
                'payload' => json_encode($request->all()),
                'error_message' => $e->getMessage()
            ]);

            //Log::error('Error processing webhook: ' . $e->getMessage());
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
        // dd($pickup);
        
        if(!$pickup->status):
            return ResponseFormatter::error("Oops!! ".$pickup?->message, 400, $pickup);
        else:
            if($pickup?->data?->status == "confirmed"):
                $wallet->save();
                $transaction->save();

                $response = $this->logistics->getShipment($request->shipment_id);
                $response = json_decode($response);
                $data = $response->data;

                $shipment = Shipment::where("external_shipment_id", $request->shipment_id)->first();
                $shipment->status = "confirmed";
                $shipment->pickup_date = $data->pickup_date;
                $shipment->save();

                if($data->extras):
                    $notificationData = [
                        "subject" => "Customer Invoice & Waybill",
                        "title" => "Ziga Afrika Invoice & Waybill",
                        "message" => "Customer invoice and waybill details",
                        "attachment1" => $data->extras->commercial_invoice_url,
                        "attachment2" => $data->extras->shipping_label_url
                    ];
                    $user->notify(new SendInvoice($notificationData));
                endif;
            endif;
        endif;

        return ResponseFormatter::success("Shipment arranged successfully", null, 200);
    }

    public function createShipment(Request $request){
        $user = User::find(Auth::user()->id);

        /*$payload = [
            "address_from"=> "AD-1JPI4GFSNF0GM1NP",
            "address_to"=> "AD-942IDPMKI5SK0LK1",
            "description"=> "white paper",
            "items"=> [
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
            ],
            //"shipment_id" => "SH-SK52SQLQEC38EE36"
        ];
        $request = new Request();
        $request->merge($payload);*/

        //Create parcel
        $parcel = $this->logistics->createParcel([
            "description" => $request->description,
            "items" => $request->items
        ]);
        $parcel = json_decode($parcel);
        $parcel = $parcel->data;

        if($request->has("shipment_id")):
            $shipment = $this->logistics->updateShipment($request->shipment_id, [
                "parcel" => $parcel->parcel_id,
                'address_from' => $request->address_from,
                'address_to' => $request->address_to
            ]);
            $shipment = json_decode($shipment);
            $shipment = $shipment->data;
            $this->editShipment($shipment);
        else:
            $shipment = $this->logistics->createShipment([
                "parcel" => $parcel->parcel_id,
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
            "parcel" => $parcel,
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

        foreach($data->parcel->items as $item):
            $newItem = new Item;
            $newItem->shipment_id = $shipment->id;
            $newItem->name = $item->name;
            $newItem->currency = $item->currency;
            $newItem->description = $item->description;
            $newItem->value = $item->value;
            $newItem->quantity = $item->quantity;
            $newItem->weight = $item->weight;
            $newItem->save();
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
        $shipment->items()->delete();

        foreach($data->parcel->items as $item):
            $newItem = new Item;
            $newItem->shipment_id = $shipment->id;
            $newItem->name = $item->name;
            $newItem->currency = $item->currency;
            $newItem->description = $item->description;
            $newItem->value = $item->value;
            $newItem->quantity = $item->quantity;
            $newItem->weight = $item->weight;
            $newItem->save();
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

    public function getCategories(Request $request){
        $categories = $this->logistics->getCategories($request->chapter);
        $categories = json_decode($categories);

        return ResponseFormatter::success($categories->message, $categories->data, 200);
    }

    public function getHsCodes(Request $request){
        $hs_codes = $this->logistics->getHsCodes($request->chapter, $request->category);
        $hs_codes = json_decode($hs_codes);

        return ResponseFormatter::success($hs_codes->message, $hs_codes->data, 200);
    }

}