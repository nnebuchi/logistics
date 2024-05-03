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
         //if(in_array($country->name, $allowedCountries)):
        //$allowedCountries = ["United Kingdom", "Nigeria", "Afghanistan", "Germany", "South Africa"];

        $response = Http::acceptJson()
            ->withToken("sk_live_HYNPAz62alrkgOI3E3Nj1mB0uojcRFWJ")
            ->get('https://api.terminal.africa/v1/countries');
        $response = json_decode($response);
        $countries = $response->data;

        foreach($countries as $country):
            // Check if the country has states
            $statesResponse = Http::acceptJson()
                ->withToken("sk_live_HYNPAz62alrkgOI3E3Nj1mB0uojcRFWJ")
                ->get('https://api.terminal.africa/v1/states?country_code='.$country->isoCode);
            $statesResponse = json_decode($statesResponse);
            $states = $statesResponse->data;

            // Only proceed if the country has states
            if (!empty($states)):
                // Create the country
                $newCountry = Country::create([
                    "name"=> $country->name,
                    "sortname"=> $country->isoCode,
                    "phonecode" => strpos($country->phonecode, '+') === 0 ? $country->phonecode : '+' . $country->phonecode
                ]);

                // Loop through the states
                foreach($states as $state) {
                    // Create the state
                    $newState = State::create([
                        "country_id" => $newCountry->id,
                        "name"=> $state->name
                    ]);

                    // Fetch cities for the state
                    $citiesResponse = Http::acceptJson()
                        ->withToken("sk_live_HYNPAz62alrkgOI3E3Nj1mB0uojcRFWJ")
                        ->get('https://api.terminal.africa/v1/cities?country_code='.$state->countryCode.'&state_code='.$state->isoCode);
                    $citiesResponse = json_decode($citiesResponse);
                    $cities = $citiesResponse->data;

                    // Create cities for the state
                    foreach($cities as $city) {
                        City::create([
                            "state_id" => $newState->id,
                            "name"=> $city->name
                        ]);
                    }
                }
            endif;
        endforeach;

    }
}
