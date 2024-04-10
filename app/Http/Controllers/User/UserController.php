<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        //$wallet = $user->wallet;
        //$transactions = $user->transactions;
        //$shipments = $transactions->shipments;

        return view('customer.index', compact('user'/*, 'wallet', 'transactions', 'shipments'*/));
    }

    public function showShipments()
    {
        $user = User::find(Auth::user()->id);

        return view('customer.shipments', compact('user'));
    }
}