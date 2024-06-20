<?php
namespace App\Services;

use App\Mail\ShippingReportMail;
use Illuminate\Support\Facades\Mail;

class ShippingService
{
    public static function reportShippingUpdate($mail_data){
        Mail::to(env("SHIPPING_REPORT_MAIL"))->send(new ShippingReportMail($mail_data));
        // Mail::to([env("SHIPPING_REPORT_MAIL"), env("ADMIN_MAIL")])->send(new ShippingReportMail($mail_data));
    }
}