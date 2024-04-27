<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\{
    Country,
    State,
    City
};

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::acceptJson()
            ->withToken("sk_live_HYNPAz62alrkgOI3E3Nj1mB0uojcRFWJ")
                ->get('https://api.terminal.africa/v1/countries');
        $response = json_decode($response);
        $countries = $response->data;
        $allowedCountries = ["United Kingdom", "Nigeria", "Afghanistan", "Germany", "South Africa"];
        foreach($countries as $country):
            if(in_array($country->name, $allowedCountries)):
                $newCountry = Country::create([
                    "name"=> $country->name,
                    "sortname"=> $country->isoCode,
                    "phonecode"=> $country->phonecode
                ]);

                $response = Http::acceptJson()
                ->withToken("sk_live_HYNPAz62alrkgOI3E3Nj1mB0uojcRFWJ")
                    ->get('https://api.terminal.africa/v1/states?country_code='.$country->isoCode);
                $response = json_decode($response);
                $states = $response->data;
                foreach($states as $state):
                    $newState = State::create([
                        "country_id" => $newCountry->id,
                        "name"=> $state->name
                    ]);

                    $response = Http::acceptJson()
                    ->withToken("sk_live_HYNPAz62alrkgOI3E3Nj1mB0uojcRFWJ")
                        ->get('https://api.terminal.africa/v1/cities?country_code='.$state->countryCode.'&state_code='.$state->isoCode);
                    $response = json_decode($response);
                    $cities = $response->data;
                    foreach($cities as $city):
                        City::create([
                            "state_id" => $newState->id,
                            "name"=> $city->name
                        ]);
                    endforeach;
                endforeach;
            endif;
        endforeach;

    }
}
