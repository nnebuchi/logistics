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
use App\Services\UserService;
use App\Http\Requests\ChangePassword;
use Illuminate\Support\Facades\Http;

class ShippingController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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

        return view('customer.shippings.create-shipping', compact('user', 'countries'));
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