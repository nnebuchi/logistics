<?php
namespace App\Services;

use App\Mail\ShippingReportMail;
use Illuminate\Support\Facades\{Mail, Response};
use App\Models\{User, Shipment, Country, Address};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Util\Logistics;


class ShippingService
{
    public static function reportShippingUpdate($mail_data){
        Mail::to(env("SHIPPING_REPORT_MAIL"))->send(new ShippingReportMail($mail_data));
        // Mail::to([env("SHIPPING_REPORT_MAIL"), env("ADMIN_MAIL")])->send(new ShippingReportMail($mail_data));
    }

    public function showShippingForm(Request $request)
    {
        $logistics = new Logistics();
        dd($logistics->getChapters());
        
        $user = User::find(Auth::user()->id);
        if($user->is_verified):
            $countries = Country::all();
            $logistics = new Logistics();   
            $response = $logistics->getChapters();
            $response = json_decode($response);
            $chapters = $response->data;

            return view('customer.shippings.create-shipping', compact('user', 'countries', 'chapters'));
        endif;
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


}