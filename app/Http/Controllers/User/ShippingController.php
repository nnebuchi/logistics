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
use Exception;
use App\Models\WebhookLog;
use App\Notifications\SendInvoice;
use App\Services\ShippingService;
use App\Services\UserService;

class ShippingController extends Controller
{
    private Logistics $logistics;

    public function __construct(Logistics $logistics)
    {
        $this->logistics = $logistics;
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

            dd($shipment);
            return view(
                'customer.shippings.edit-shipping', 
                compact('user', 'shipment', 'countries', 'chapters', 'states', 'cities')
            );
        endif;
    }

    public function getUserShipments(Request $request)
    {
       return ShippingService::getUserShipments($request);
    }

    public function newShipment(){
        return view('customer.shippings.new')->with(['user'=>Auth::user()]);
    }

    public function showShippingForm(Request $request)
    {
        return ShippingService::showShippingForm($request);
      
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
        $validator = Validator::make($request->all(), [
            'rate_id' => 'required|string',
            'shipment_id' => 'required|integer',
            'total' => 'numeric'
        ]);

        if($validator->fails()):
            return response([
                'status'=>'fail',
                'message' => "Failed to update document",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        endif;
        return ShippingService::makePayment($request);
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
        

        if($request->has("shipment_id")):
            $response = $this->editShipment($request->all(), $request->description);
        else:
            return ShippingService::saveShipment($request);
        endif;
        $parcels = $response["parcels"];
        $shipment = $response["shipment"];

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
            'attachment.*' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if($validator->fails()):
            return response([
                'message' => "Failed to update document",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        endif;

        return ShippingService::uploadParcelDocument($request);
    }

    public function saveShipment($data, User $user, $description){
            $shipment = new Shipment;
            $shipment->user_id = $user->id;
            //$shipment->external_shipment_id = $data->shipment_id;
            //$shipment->pickup_date = $data->pickup_date;
            $shipment->save();
    
        $parcels = [];
        foreach($data["items"] as $parcel):
            $newParcel = new Parcel;
            $newParcel->shipment_id = $shipment->id;
            $newParcel->metadata = $parcel["docs"];
    
            $response = $this->logistics->createParcel([
                "description" => $description,
                "items" => $parcel["items"],
                "docs" => array_column($parcel["docs"], 'photo')
            ]);
            $response = json_decode($response);
            $response = $response->data;
            
            $newParcel->external_parcel_id = $response->parcel_id;
            $newParcel->weight = $response->total_weight;
            $newParcel->weight_unit = $response->weight_unit;
            $newParcel->save();
            array_push($parcels, $response);
    
            foreach($response->items as $item):
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

        $newShipment = $this->logistics->createShipment([
            "parcels" => array_column($parcels, "parcel_id"),
            'address_from' => $data["address_from"],
            'address_to' => $data["address_to"]
        ]);
        $newShipment = json_decode($newShipment);
        $newShipment = $newShipment->data;

        // Update the shipment with external ID and pickup date
        $shipment->external_shipment_id = $newShipment->shipment_id;
        $shipment->pickup_date = $newShipment->pickup_date;
        $shipment->save();
    
        $from = new Address;
        $from->shipment_id = $shipment->id;
        $from->firstname = $newShipment->address_from->first_name;
        $from->lastname = $newShipment->address_from->last_name;
        $from->email = $newShipment->address_from->email;
        $from->phone = $newShipment->address_from->phone;
        $from->country = $newShipment->address_from->country;
        $from->state = $newShipment->address_from->state;
        $from->city = $newShipment->address_from->city;
        $from->zip = $newShipment->address_from->zip;
        $from->line1 = $newShipment->address_from->line1;
        $from->type = "from";
        $from->save();
    
        $to = new Address;
        $to->shipment_id = $shipment->id;
        $to->firstname = $newShipment->address_to->first_name;
        $to->lastname = $newShipment->address_to->last_name;
        $to->email = $newShipment->address_to->email;
        $to->phone = $newShipment->address_to->phone;
        $to->country = $newShipment->address_to->country;
        $to->state = $newShipment->address_to->state;
        $to->city = $newShipment->address_to->city;
        $to->zip = $newShipment->address_to->zip;
        $to->line1 = $newShipment->address_to->line1;
        $to->type = "to";
        $to->save();

        return ["parcels" => $parcels, "shipment" => $newShipment];
    }

    public static function saveAddress(Request $request){
        return ShippingService::saveAddress($request);
    }

    public function saveParcel(Request $request){
        return ShippingService::saveParcel($request);
    }

    public function saveItem(Request $request){
        return ShippingService::saveItem($request);
    }

    public function getShipment(Request $request){
        return ShippingService::getShipment($request->id);
    }

    public function deleteItem(Request $request){
        return ShippingService::deleteItem($request->id);
    }

    public function deleteParcel(Request $request){
        return ShippingService::deleteParcel($request->id);
    }

    public function deleteShipment($slug){
        return ShippingService::deleteShipment($slug);
    }
    

    public function editShipment($data, $description){
        $shipment = Shipment::where("external_shipment_id", $data["shipment_id"])->first();
        $shipment->parcels()->delete();
        $shipment->items()->delete();

        $parcels = [];
        foreach($data["items"] as $parcel):
            $newParcel = new Parcel;
            $newParcel->shipment_id = $shipment->id;
            $newParcel->metadata = $parcel["docs"];
    
            $response = $this->logistics->createParcel([
                "description" => $description,
                "items" => $parcel["items"],
                "docs" => array_column($parcel["docs"], 'photo')
            ]);
            $response = json_decode($response);
            $response = $response->data;
            
            $newParcel->external_parcel_id = $response->parcel_id;
            $newParcel->weight = $response->total_weight;
            $newParcel->weight_unit = $response->weight_unit;
            $newParcel->save();
            array_push($parcels, $response);
    
            foreach($response->items as $item):
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

        $newShipment = $this->logistics->updateShipment($data["shipment_id"], [
            "parcels" => array_column($parcels, "parcel_id"),
            'address_from' => $data["address_from"],
            'address_to' => $data["address_to"]
        ]);
        $newShipment = json_decode($newShipment);
        $newShipment = $newShipment->data;

        // Update the shipment with external ID and pickup date
        $shipment->pickup_date = $newShipment->pickup_date;
        $shipment->save();

        

        $to = Address::where(["shipment_id" => $shipment->id, "type" => "to"])->first();;
        $to->firstname = $newShipment->address_to->first_name;
        $to->lastname = $newShipment->address_to->last_name;
        $to->email = $newShipment->address_to->email;
        $to->phone = $newShipment->address_to->phone;
        $to->country = $newShipment->address_to->country;
        $to->state = $newShipment->address_to->state;
        $to->city = $newShipment->address_to->city;
        $to->zip = $newShipment->address_to->zip;
        $to->line1 = $newShipment->address_to->line1;
        $to->type = "to";
        $to->save();

        return ["parcels" => $parcels, "shipment" => $newShipment];
    }

    public function getCarriers($id){
        return ShippingService::getCarriers($id);
    }


}