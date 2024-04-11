<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Util\Paystack;
use App\Util\ResponseFormatter;

class TransactionController extends Controller
{
    public function filter(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $wallet = $user->wallet;
        $query = Transaction::where('wallet_id', $wallet->id);

        // Filter transactions by type
        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }

        // Filter transactions by status
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter transactions by date
        if ($request->has('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        // Get filtered transactions
        $transactions = $query->get();

        return ResponseFormatter::success("Filtered Trx:", $transactions, 200); 
    }
}