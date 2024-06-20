<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShippingReportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mail_data;
    
    public function __construct($mail_data)
    {
        $this->mail_data = $mail_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        // dd($this->mail_data);
        return $this->mail_data['type'] === 'error' ?
             $this->view('email.admin.event-error')->subject('Shipping Update Error')
             :
             $this->view('email.admin.event-success')->subject('Shipping-Update');
    }
}
