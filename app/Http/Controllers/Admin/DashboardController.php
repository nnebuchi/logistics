<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use App\Util\Helper;
use Illuminate\Support\Facades\Auth;
use App\Util\ResponseFormatter;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Admin::find(Auth::user()->id);
        $transactions = Transaction::with(["wallet.user"])->orderByDesc("created_at")->get();
        
        return view('admin.index', compact('user', 'transactions'));
    }

    public function showUsers()
    {
        $user = Admin::find(Auth::user()->id);
        $accounts = Account::all();
        
        return view('admin.users.user', compact('user', 'accounts'));
    }

    public function getUsers(Request $request)
    {
        // Check if perPage and page parameters are present in the request
        if(!$request->has("perPage") && !$request->has("page")) {
            // Fetch all users without pagination
            $users = User::orderBy("firstname")->get();
            
            return ResponseFormatter::success("Users:", ["data" => $users]);
        }
    
        $perPage =  $request->query("perPage", 5); // Default per page is 10
        $page = $request->query("page", 1); // Default page is 1

        $query = User::orderByDesc("created_at");

        // Get filtered transactions
        $users = $query->paginate($perPage, ["*"], "page", $page);
        
        return ResponseFormatter::success(
            "Users:", 
            $users
        );
    }

    public function getUserData(Request $request, $userId)
    {
        $user = User::find($userId);
        
        return ResponseFormatter::success(
            "User Data:", 
            $user
        );
    }

    public function showTransactions()
    {
        $user = Admin::find(Auth::user()->id);
        
        return view('admin.transactions.transaction', compact('user'));
    }

    public function getTransactions(Request $request)
    {
        $perPage =  $request->query("perPage", 5); // Default per page is 10
        $page = $request->query("page", 1); // Default page is 1

        $query = Transaction::with(["wallet.user"])->orderByDesc("created_at");
        // Filter transactions by ID
        if ($request->has('reference')):
            $query->where('reference', $request->input('reference'));
        endif;

        // Filter transactions by email
        if ($request->has('email')):
            $email = $request->input('email');
            $query->whereHas('wallet.user', function ($query) use ($email) {
                $query->where('email', $email);
            });
        endif;

        // Get filtered transactions
        $transactions = $query->paginate($perPage, ["*"], "page", $page);

        return ResponseFormatter::success("Transactions:", $transactions, 200); 
    }

    public function showRates()
    {
        $user = Admin::find(Auth::user()->id);
        
        return view('admin.rates.rate', compact('user'));
    }

    public function fetchStatistics()
    {
        $data = [
            "customers_count" => User::count(),
            "customers_last_week" => Helper::getNewUsersLast7Days(),
            "transactions_cost_last_week" => Helper::fetchTransactionsCostInPastWeek(),
            "transactions_cost_last_month" => Helper::fetchTransactionsCostInPastMonth()
        ];

        return ResponseFormatter::success(
            "Dashboard Statistcs::", 
            $data
        );
    }
}
