<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Util\ResponseFormatter;
use App\Services\UserService;
use App\Http\Requests\ChangePassword;

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

        return view('customer.shippings.create-shipping', compact('user'));
    }

}