<?php
namespace App\Services;

use App\Mail\ShippingReportMail;
use Illuminate\Support\Facades\{Mail, Response};
use App\Models\{User, Shipment, Country, Address, Parcel, Item, Attachment};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Util\Logistics;
use Inertia\Inertia;


class ShippingService
{
    public static function reportShippingUpdate($mail_data){
        Mail::to(env("SHIPPING_REPORT_MAIL"))->send(new ShippingReportMail($mail_data));
        // Mail::to([env("SHIPPING_REPORT_MAIL"), env("ADMIN_MAIL")])->send(new ShippingReportMail($mail_data));
    }

    public static function showShippingForm(Request $request)
    {   
        
        $slug = $request->slug;
        $shipment = Shipment::with('address_from', 'address_to', 'items', 'parcels')->where("slug", $slug)->first();

       
        $fromStates = $shipment?->address_from?->nation()?->first()->states;
        
        $toStates = $shipment?->address_to?->nation()?->first()->states;
       
        $fromCities = $shipment?->address_from?->hostState()?->first()->cities;
        
        $toCities = $shipment?->address_to?->hostState()?->first()->cities;

        $parcels = json_encode($shipment->parcels);
       
        $user = User::find(Auth::user()->id);
       
        $countries = Country::all();
        //  $cc =json_encode($countries, true);
        //  dd($cc);

        $logistics = new Logistics();
    

        $response = $logistics->getChapters();
        // dd($response);
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

        // return Inertia::render('Shipping/Parcel', []);
        return view('customer.shippings.create-shipping', compact('user', 'shipment', 'countries', 'chapters', 'states', 'cities', 'slug', 'parcels'));
        
        // $logistics = new Logistics();
        // dd($logistics->getChapters());
        
        // $user = User::find(Auth::user()->id);
        // if($user->is_verified):
        //     $countries = Country::all();
        //     $logistics = new Logistics();   
        //     $response = $logistics->getChapters();
        //     $response = json_decode($response);
        //     $chapters = $response->data;

        //     return view('customer.shippings.create-shipping', compact('user', 'countries', 'chapters'));
        // endif;
    }

    public static function saveShipment(Request $request){
        $user = User::find(Auth::user()->id);
        $shipment = new Shipment;
        $shipment->user_id = $user->id;
        $shipment->title = sanitize_input($request->title);
        $shipment->slug = slugify($shipment->title);
        $shipment->save();
        return redirect()->route('add-shipment', $shipment->slug);
    }

    public static function saveAddress(Request $request){
        // dd(Auth::user()->id);
        $shipment = Shipment::where(['slug'=>sanitize_input($request->slug), 'user_id'=>Auth::user()->id])->first();
        // dd($shipment);

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
            }
            if($request->type == 'receiver'){
                $address->type = 'to';
            }
            // $address->type =   ? sanitize_input($request->type);
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
            'shipment' => Shipment::where(['id'=>$parcel->shipment_id, 'user_id'=>Auth::user()->id])->with('parcels.items')->first(),
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

            // dd($newItem);
        }else{
            $newItem = new Item;
            $newItem->parcel_id = sanitize_input($request->parcel_id);
            $newItem->shipment_id = sanitize_input($request->shipment_id);
            $newItem->description = sanitize_input($request->description);
        }
        
        
        $newItem->name = sanitize_input($request->name);
        $newItem->currency = sanitize_input($request->currency);
        $newItem->value = sanitize_input($request->value);
        $newItem->quantity = sanitize_input($request->quantity);
        $newItem->weight = sanitize_input($request->weight);
        $newItem->category = sanitize_input($request->category);
        $newItem->sub_category = sanitize_input($request->sub_category);

        $newItem->save();
        

        return Response::json([
            'status'    => 'success',
            'item'   => $newItem,
            'shipment' => Shipment::where(['id'=>$newItem->shipment_id, 'user_id'=>Auth::user()->id])->with('parcels.items')->first(),
        ], 201);
        
    }

    public static function getShipment(string $id){
        return Response::json([
            'status'    => 'success',
            'shipment'   => Shipment::where(['id'=>$id, 'user_id'=>Auth::user()->id])->with('parcels.items')->first(),
        ], 200);
    }

    public static function deleteItem($id){
        $item = Item::where('id', sanitize_input($id))
        ->whereHas('shipment', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->first();

        $other_items_count = Item::where('parcel_id', $item->id)->count();

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
            $url = cloudinary()->upload($file->getRealPath())->getSecurePath();
            $attachment = new Attachment();
            $attachment->file = $url;
            $attachment->parcel_id = sanitize_input($request->parcel_id);
            $attachment->type = sanitize_input($request->type);
            $attachment->save();
        }
        return Response::json([
            'status'    => 'success',
            'message'   => 'file uploaded',
            'shipment' => $attachment->parcel->shipment,
        ], 200);
    }
}