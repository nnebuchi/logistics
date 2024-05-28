<?php

namespace App\Util;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class Paystack
{
    private $baseUrl;
    private $secretKey;
    //private Client $client;

    public function __construct()
    {
        $this->setBaseUrl();
        $this->setKey();
    }

    public function setKey()
    {
        $this->secretKey = env('PAYSTACK_SECRET', '');
        $client = new Client;
        $this->client = $client;
    }

    public function setBaseUrl()
    {
        $this->baseUrl = 'https://api.paystack.co/';
    }

    public function getPaymentData($reference)
    {
        $url = $this->baseUrl.'transaction/verify/'.$reference;
        $response = $this->client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Bearer '.$this->secretKey
            ]
        ]);
        return $response->getBody();
    }

    public function getTransactions()
    {
        $response = $this->client->request('GET', $this->baseUrl.'transaction', [
            'headers' => [
                'Authorization' => 'Bearer '.$this->secretKey
            ]
        ]);
        return $response->getBody();
    }

    public function initiateDeposit(
        $email, $amount, $reference, $plan
    )
    {
        $callback = url("api/card-subscription");
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->post($this->baseUrl."transaction/initialize", [
                    'email' => $email,
                    'amount' => $amount * 100, 
                    'callback_url' => $callback,
                    'channels' => [
                        'bank'
                    ],
                    'reference' => $reference,
                    'plan' => $plan
                ]);
        return $response;
    }

    public function createTransferRecipient(
        $account, $name, $code
    )
    {
        $response = Http::acceptJson()
        ->withToken($this->secretKey)
        ->post($this->baseUrl.'transferrecipient', [
            'type' => 'nuban',
            'currency' => 'NGN',
            'account_number' => $account,
            'name' => $name,
            'bank_code' => $code,
        ]);
        return $response;
    }

    public function sendMoney(array $data)
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
            ->post($this->baseUrl.'transfer', [
                'recipient' => $data['recipient'],
                'amount' => $data['amount'] * 100,
                'source' => "balance",
                'reason' => $data['reason'],
                'reference' => $data['reference']
            ]);
            return $response;
    }
    
    public function resolve(array $data)
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($this->baseUrl."bank/resolve", $data);
        return $response;
    }

    public function getBankList()
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($this->baseUrl.'bank', [
                    'country' => 'nigeria',
                ]);
        return $response;
    }

    public function getBank($code)
    {
        $response = $this->getBankList();
        $data = $response['data'];
        foreach($data as $array):
            if($array["code"] == $code):
                $bank = $array["name"];
            endif;
            global $bank;
        endforeach;
        return $bank;
    }

    public function fetchAllTransfers()
    {
        $url = $this->baseUrl.'transfer';
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($url, [
                    'perPage' => '',  //default 50
                    'page' => '',   //defult 1
                    'customer' => '',   //filter by customer ID
                    'from' => '',   //A timestamp from which to start listing transfers
                    'to' => ''    //A timestamp from which to stop listing transfers
                ]);
        return $response;
    }

    public function fetchTransferData($id_or_code)
    {
        $url = $this->baseUrl.'transfer/'.$id_or_code;
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($url);
        return $response;
    }

    public function verifyTransfer($reference)
    {
        $url = $this->baseUrl.'transfer/verify/'.$reference;
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($url);
        return $response;
    }
    
    public function fetchBalance()
    {
        $url = $this->baseUrl.'balance/';
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($url);
        return $response;
    }

    public function createPlan($data)
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->post($this->baseUrl."plan", [
                    'name' => $data["name"],
                    'interval' => $data["interval"], 
                    'amount' => $data["amount"] * 100,
                    'invoice_limit' => 1
                ]);
        return $response;
    }

    public function updatePlan($data, $id_or_code)
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->put($this->baseUrl."plan/".$id_or_code, [
                    'name' => $data["name"],
                    'interval' => $data["interval"], 
                    'amount' => $data["amount"] * 100,
                    'invoice_limit' => 1,
                    'send_invoices' => false,
                    'send_sms' => false
                ]);
        return $response;
    }

    public function listPlans()
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($this->baseUrl."plan");
        return $response;
    }

    public function fetchPlan($id_or_code)
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($this->baseUrl."plan/".$id_or_code);
        return $response;
    }

    //fetch subscription with code
    public function fetchSubscription($subscription_code)
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($this->baseUrl."subscription/".$subscription_code);
        return $response;
    }

    public function enableSubscription()
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($this->baseUrl."subscription/enable", [
                    "token" => $token,
                    "code" => $code
                ]);
        return $response;
    }

    public function disableSubscription()
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($this->baseUrl."subscription/disable", [
                    "token" => $token,
                    "code" => $code
                ]);
        return $response;
    }

    public function listSubscriptions()
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($this->baseUrl."subscription");
        return $response;
    }

    public function fetchCustomer($email)
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($this->baseUrl."customer/".$email);
        return $response;
    }

}