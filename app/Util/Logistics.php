<?php

namespace App\Util;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class Logistics
{
    private $baseUrl;
    private $secretKey;
    private Client $client;

    public function __construct(Client $client)
    {
        // $this->setBaseUrl();
        // $this->setKey();
        $this->secretKey = env('TERMINAL_AFRICA_SECRET_KEY');
        $this->baseUrl = env('TERMINAL_AFRICA_URI', '');
        $this->client = $client;
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
        /*$response = Http::acceptJson()
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
        return $response;*/
        $response = $this->client->request('POST', $this->baseUrl.'addresses', [
            'http_errors' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$this->secretKey
            ],
            'json' => [
                'city' => $payload["city"],
                'state' => $payload["state"],
                'country' => $payload["country"],
                'email' => $payload["email"],
                'first_name' => $payload["firstname"],
                'last_name' => $payload["lastname"],
                'line1' => $payload["line1"],
                'phone' => $payload["phone"],
                'zip' => $payload["zip"]
            ]
        ]);
        return $response->getBody();
    }

    public function createParcel($payload)
    {
        $response = $this->client->request('POST', $this->baseUrl.'parcels', [
            'headers' => [
                'Authorization' => 'Bearer '.$this->secretKey
            ],
            'json' => [
                'description' => $payload["description"],
                'items' => $payload["items"],
                'weight_unit' => 'kg',
                'rec_docs' => $payload["docs"]
            ]
        ]);
        return $response->getBody();
    }

    public function createShipment($payload)
    {
        $response = $this->client->request('POST', $this->baseUrl.'shipments', [
            'headers' => [
                'Authorization' => 'Bearer '.$this->secretKey
            ],
            'json' => [
                'address_from' => $payload["address_from"],
                'address_to' => $payload["address_to"],
                'parcels' => $payload["parcels"]
            ]
        ]);
        return $response->getBody();
    }

    public function updateShipment($shipment_id, $payload)
    {
        $response = $this->client->request('PUT', $this->baseUrl.'shipments/'.$shipment_id, [
            'headers' => [
                'Authorization' => 'Bearer '.$this->secretKey
            ],
            'json' => [
                'address_from' => $payload["address_from"],
                'address_to' => $payload["address_to"],
                'parcels' => $payload["parcels"]
            ]
        ]);
        return $response->getBody();
    }

    public function getShipments()
    {
        /*$response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($this->baseUrl.'shipments');
        return $response;*/
        $response = $this->client->request('GET', $this->baseUrl.'shipments', [
            'headers' => [
                'Authorization' => 'Bearer '.$this->secretKey
            ]
        ]);
        return $response->getBody();
    }

    public function getShipment($shipment_id)
    {
        /*$response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->get($this->baseUrl.'shipments/'.$shipment_id);
        return $response;*/
        $response = $this->client->request('GET', $this->baseUrl.'shipments/'.$shipment_id, [
            'headers' => [
                'Authorization' => 'Bearer '.$this->secretKey
            ]
        ]);
        return $response->getBody();
    }

    public function arrangePickup($data)
    {
        /*$response = Http::acceptJson()
            ->withToken($this->secretKey)
                ->post($this->baseUrl.'shipments/pickup', [
                    'rate_id' => $data["rate_id"]
                    //'shipment_id' => $data["shipment_id"],
                    //'purchase_insurance' => $data["purchase_insurance"]
                ]);
        return $response;*/
        $response = $this->client->request('POST', $this->baseUrl.'shipments/pickup', [
            'http_errors' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$this->secretKey
            ],
            'json' => [
                'rate_id' => $data["rate_id"]
                //'shipment_id' => $data["shipment_id"],
                //'purchase_insurance' => $data["purchase_insurance"]
            ] 
        ]);
        // dd($response);
        return $response->getBody();
    }

    public function getRateForShipment($data)
    {
        $response = $this->client->request('POST', $this->baseUrl.'rates/multi/shipment', [
            'headers' => [
                'Authorization' => 'Bearer '.$this->secretKey
            ],
            'json' => [
                'currency' => 'NGN',
                'shipment_id' => $data["shipment_id"],
                'pickup_address' => $data["address_from"],
                'delivery_address' => $data["address_to"]
            ]
        ]);
        return $response->getBody();
    }

    public function trackShipment($shipment_id)
    {
        $response = $this->client->request('GET', $this->baseUrl.'shipments/track/'.$shipment_id, [
            'headers' => [
                'Authorization' => 'Bearer '.$this->secretKey
            ]
        ]);
        return $response->getBody();
    }

    public function getChapters()
    {
        $response = $this->client->request('GET', $this->baseUrl.'hs-codes/simplified/chapters/', [
            'headers' => [
                'Authorization' => 'Bearer '.$this->secretKey
            ]
        ]);
        return $response->getBody();
    }

    public function getCategories($chapter)
    {
        $response = $this->client->request('GET', $this->baseUrl.'hs-codes/simplified/category', [
            'headers' => [
                'Authorization' => 'Bearer '.$this->secretKey
            ],
            'query' => [
                'chapter' => $chapter
            ]
        ]);
        return $response->getBody();
    }

    public function getHsCodes($chapter, $category)
    {
        $response = $this->client->request('GET', $this->baseUrl.'hs-codes/simplified', [
            'headers' => [
                'Authorization' => 'Bearer '.$this->secretKey
            ],
            'query' => [
                'chapter' => $chapter,
                'category_code' => $category
            ]
        ]);
        return $response->getBody();
    }


}