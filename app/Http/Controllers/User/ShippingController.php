<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Util\ResponseFormatter;
use App\Util\Logistics;
use App\Services\UserService;
use App\Http\Requests\ChangePassword;
use Illuminate\Support\Facades\Http;

class ShippingController extends Controller
{
    private UserService $userService;
    private $logistics;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->logistics = new Logistics();
    }

    public function showShippings()
    {
        $user = User::find(Auth::user()->id);

        return view('customer.shippings.shipping', compact('user'));
    }

    public function showShippingForm()
    {
        $user = User::find(Auth::user()->id);
        $countries = Country::all();

        /*$payload = [
            'description' => 'New parcel for shipment',
            'items' => [
                [
                    'description' => 'Purple cotton and t-shirt, size L',
                    'hs_code' => '6205',
                    'name' => 'Shirt',
                    'type' => 'parcel',
                    'currency' => 'USD',
                    'value' => 25.99,
                    'quantity' => 1,
                    'weight' => 0.2
                ]
            ]
        ];
     
        return $this->logistics->createParcel($payload);*/
        

        // $response = Http::acceptJson()
        //     ->withToken("sk_live_HYNPAz62alrkgOI3E3Nj1mB0uojcRFWJ")
        //         ->get('https://api.terminal.africa/v1/hs-codes/simplified/chapters');
        // $response = json_decode($response);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.terminal.africa/v1/hs-codes/simplified/chapters/', [
            'headers' => [
                'Authorization' => 'Bearer '.env('TERMINAL_AFRICA_SECRET_KEY')
            ]
        ]);
        $response = json_decode($response->getBody());
        $chapters = $response->data;

        return view('customer.shippings.create-shipping', compact('user', 'countries', 'chapters'));
    }

    public static function getStates(int $countryId)
    {
        $states = State::where(['country_id' => $countryId])->get();

        return ResponseFormatter::success("States:", $states, 200);
    }
    
    public static function getCities(int $stateId)
    {
        $cities = City::where(['state_id' => $stateId])->get();
            
        return ResponseFormatter::success("Cities:", $cities, 200);
    }

}