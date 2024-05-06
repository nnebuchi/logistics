<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\{
    Shipment,
    Address,
    Item
};

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::acceptJson()
            ->withToken("sk_live_gTOiIxwqDNlY66eXjYPVkt2m3lddt8Ti")
            ->get('https://api.terminal.africa/v1/shipments/SH-K4PIUYK9U36CUBIB');
        $response = json_decode($response);
        $data = $response->data;

        $shipment = new Shipment;
        $shipment->user_id = 7;
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
}
