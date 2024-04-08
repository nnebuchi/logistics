<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;

class WalletController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $wallet = $user->wallet;
        $transactions = $user->transactions;

        // Pass both $user, transactions and $wallet variables to the view
        return view('customer.wallet', compact('user', 'wallet', 'transactions'));
    }

    public function fund($payload)
    {
        
    }
}