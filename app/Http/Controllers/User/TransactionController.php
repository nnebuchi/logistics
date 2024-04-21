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
    public function getUserTransactions(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $wallet = $user->wallet;
        $query = Transaction::where('wallet_id', $wallet->id)->orderByDesc("created_at");

        // Filter transactions by type
        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }

        // Filter transactions by status
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter transactions by date range
        if ($request->has('date')) {
            $date = $request->input('date');
            // If startDate and endDate are present, filter transactions within the specified date range
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } else {
                // If only date is present, filter transactions for the given date
                //$query->whereDate('created_at', $date);
            }
        }

        // Get filtered transactions
        $transactions = $query->get();

        return ResponseFormatter::success("Filtered Trx:", $transactions, 200); 
    }

}