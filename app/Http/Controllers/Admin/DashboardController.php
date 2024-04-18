<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Admin::find(Auth::user()->id);
        $transactions = Transaction::with(["wallet.user"])->get();
        
        return view('admin.index', compact('user', 'transactions'));
    }

    public function showUsers()
    {
        $user = Admin::find(1);
        $users = User::all();
        
        return view('admin.users.user', compact('users', 'user'));
    }

    public function showTransactions()
    {
        $user = Admin::find(1);
        $transactions = Transaction::with(["wallet.user"])->get();
        
        return view('admin.transactions.transaction', compact('transactions', 'user'));
    }
}
