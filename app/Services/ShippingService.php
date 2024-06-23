<?php
namespace App\Services;

use App\Mail\ShippingReportMail;
use Illuminate\Support\Facades\Mail;
use App\Models\{User, Shipment};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ShippingService
{
    public static function reportShippingUpdate($mail_data){
        Mail::to(env("SHIPPING_REPORT_MAIL"))->send(new ShippingReportMail($mail_data));
        // Mail::to([env("SHIPPING_REPORT_MAIL"), env("ADMIN_MAIL")])->send(new ShippingReportMail($mail_data));
    }

    public static function saveShipment(Request $request){
        $user = User::find(Auth::user()->id);
        $shipment = new Shipment;
        $shipment->user_id = $user->id;
        $shipment->title = sanitize_input($request->title);
        $shipment->slug = slugify($shipment->title);
        $shipment->save();
        return $shipment;
    }
}