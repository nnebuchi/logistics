<?php

namespace App\Util;

use Illuminate\Support\Facades\Http;

class Logistics
{
    private $baseUrl;
    private $secretKey;

    public function __construct()
    {
        $this->setBaseUrl();
        $this->setKey();
    }

    public function setKey()
    {
        $this->secretKey = env('TERMINAL_AFRICA_SECRET_KEY', '');
    }

    public function setBaseUrl()
    {
        $this->baseUrl = env('TERMINAL_AFRICA_URI', '');
    }

    public function createAddress($payload)
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->post($this->baseUrl.'addresses', [
                    'city' => $payload["city"],
                    'state' => $payload["state"],
                    'country' => $payload["country"],
                    'email' => $payload["email"],
                    'first_name' => $payload["firstname"],
                    'last_name' => $payload["lastname"],
                    'line1' => $payload["line1"],
                    'phone' => $payload["phone"],
                    'zip' => $payload["zip"]
                ]);
        return $response;
    }

    public function createParcel($payload)
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->post($this->baseUrl.'parcels', [
                    'description' => $payload["description"],
                    'items' => $payload["items"],
                    'weight_unit' => 'kg'
                ]);
        return $response;
    }

    public function createShipment($payload)
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->post($this->baseUrl.'shipments', [
                    'address_from' => $payload["address_from"],
                    'address_to' => $payload["address_to"],
                    'parcel' => $payload["parcel"]
                ]);
        return $response;
    }

    public function updateShipment($shipment_id, $payload)
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->put($this->baseUrl.'shipments/'.$shipment_id, [
                    'address_from' => $payload["address_from"],
                    'address_to' => $payload["address_to"],
                    'parcel' => $payload["parcel"]
                ]);
        return $response;
    }

    public function getShipments()
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($this->baseUrl.'shipments');
        return $response;
    }

    public function getShipment($shipment_id)
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($this->baseUrl.'shipments/'.$shipment_id);
        return $response;
    }

    public function arrangePickup($data)
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->post($this->baseUrl.'shipments/pickup', [
                    'rate_id' => $data["rate_id"]
                    //'shipment_id' => $data["shipment_id"],
                    //'purchase_insurance' => $data["purchase_insurance"]
                ]);
        return $response;
    }

    public function getRateForShipment($data)
    {
        $response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($this->baseUrl.'rates/shipment', [
                    'currency' => 'NGN',
                    'shipment_id' => $data["shipment_id"],
                    'pickup_address' => $data["address_from"],
                    'delivery_address' => $data["address_to"]
                ]);
        return $response;
    }

}