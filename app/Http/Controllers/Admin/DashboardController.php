<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Admin, User, Account, Shipment, Transaction, Wallet};
use App\Util\Helper;
use Illuminate\Support\Facades\{DB, Auth};
use App\Util\ResponseFormatter;
use App\Http\Requests\CreateAccount;
use App\Services\ShippingService;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Admin::find(Auth::user()->id);
        $transactions = Transaction::with('wallet.user')->orderByDesc("created_at")->get();
        // dd($transactions);
        $statistics = [
            "customers_count" => User::count(),
            "customers_last_week" => Helper::getNewUsersLastWeek(),
            "transactions_cost_last_week" => Helper::fetchTransactionsCostInPastWeek(),
            "transactions_cost_last_month" => Helper::fetchTransactionsCostInPastMonth()
        ];
        
        return view('admin.index', compact('user', 'transactions', 'statistics'));
    }

    public function showUsers()
    {
        $user = Admin::find(Auth::user()->id);
        $accounts = Account::all();
        
        return view('admin.users.users', compact('user', 'accounts'));
    }

    public function showAccounts()
    {
        $user = Admin::find(Auth::user()->id);
        $accounts = Account::all();
        
        return view('admin.accounts', compact('user', 'accounts'));
    }

    public function showUser($uuid)
    {
        $user = Admin::find(Auth::user()->id);
        $customer = User::where("uuid", $uuid)->first();
        
        return view('admin.users.view-user', compact('user', 'customer'));
    }

    public function getUserData(Request $request, $userId)
    {
        $user = User::with("wallet")->where("id", $userId)->first();
        
        return ResponseFormatter::success(
            "User Data:", 
            $user
        );
    }

    public function getAdminData(Request $request, $userId)
    {
        $user = Admin::find($userId);
        $roles = $user->getRoleNames(); // Returns a collection
        
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
        
        // Check if a combined search term is provided
        if ($request->has('searchTerm')) {
            $searchTerm = $request->input('searchTerm');

            $query->where(function ($query) use ($searchTerm) {
                $query->where('reference', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('wallet.user', function ($query) use ($searchTerm) {
                        $query->where('email', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        // Filter transactions by date range
        if ($request->has('startDate') || $request->has('endDate')) {
            if ($request->has('startDate')) {
                $startDate = $request->input('startDate');
            }
        
            if ($request->has('endDate')) {
                $endDate = $request->input('endDate');
            }
        
            $query->where(function ($query) use ($startDate, $endDate) {
                if (isset($startDate) && isset($endDate)) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } elseif (isset($startDate)) {
                    $query->where('created_at', '>=', $startDate);
                } elseif (isset($endDate)) {
                    $query->where('created_at', '<=', $endDate);
                }
            });
        }

        $transactions = $query->get();

        // Get filtered transactions
        //$transactions = $query->paginate($perPage, ["*"], "page", $page);

        return ResponseFormatter::success("Transactions:", $transactions, 200); 
    }

    public function showShippings()
    {
        $user = Admin::find(Auth::user()->id);
        $shipments = Shipment::orderByDesc("created_at")->get();

        // return ResponseFormatter::success("Shipments:", $shipments->get(), 200);
        
        return view('admin.shipping.shipping', compact('user', 'shipments'));
    }

    public function showAdmins()
    {
        $user = Admin::find(Auth::user()->id);
        $roles = $user->getRoleNames(); // Returns a collection
        $admins = Admin::orderByDesc("created_at")->get(); 
        $roles = Role::all();
        
        return view('admin.admins', compact('user', 'admins', 'roles'));
    }

    public function deleteCustomer($userId){
        $user = User::find($userId);
        $user->delete();

        $users = User::orderByDesc("created_at")->get();
        
        return ResponseFormatter::success("users:", $users, 200);
    }

    public function getAllShipment(Request $request){
       return ShippingService::getAllShipment($request);
    }

    public function getAllCustomers(Request $request){
        $query = User::orderByDesc("created_at");

        // Check if a combined search term is provided
        if ($request->has('searchTerm')) {
            $searchTerm = $request->input('searchTerm');

            $query->where(function ($query) use ($searchTerm) {
                $query->where('email', 'like', '%' . $searchTerm . '%')
                ->orWhere('phone', 'like', '%' . $searchTerm . '%')
                ->orWhere('firstname', 'like', '%' . $searchTerm . '%')
                ->orWhere('lastname', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter transactions by date range
        if ($request->has('startDate') || $request->has('endDate')) {
            if ($request->has('startDate')) {
                $startDate = $request->input('startDate');
            }
        
            if ($request->has('endDate')) {
                $endDate = $request->input('endDate');
            }
        
            $query->where(function ($query) use ($startDate, $endDate) {
                if (isset($startDate) && isset($endDate)) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } elseif (isset($startDate)) {
                    $query->where('created_at', '>=', $startDate);
                } elseif (isset($endDate)) {
                    $query->where('created_at', '<=', $endDate);
                }
            });
        }

        $users = $query->get();

        return ResponseFormatter::success("users:", $users, 200);
    }

    public function createAccount(CreateAccount $request){
        $account = new Account();
        $account->name = $request->name;
        $account->markup_price = $request->price;
        $account->save();

        $accounts = Account::all();

        return ResponseFormatter::success("account:", $accounts, 200);
    }

    public function updateAccount(CreateAccount $request, $accountId){
        $account = Account::find($accountId);
        $account->name = $request->name;
        $account->markup_price = $request->price;
        $account->save();

        $accounts = Account::all();

        return ResponseFormatter::success("account:", $accounts, 200);
    }

    public function getChartData()
    {
        $desiredYear = Carbon::now()->year;
        $desiredMonths = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $chartData = [];

        foreach ($desiredMonths as $month) {
            $startDate = Carbon::create($desiredYear, $month, 1);
            $endDate = Carbon::create($desiredYear, $month, 1)->addMonth();

            $revenue = DB::table('transactions')
            ->where("status", "success")
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

            if($revenue === null):
                $chartData[] = 0;
            else:
                $chartData[] = $revenue;
            endif;
        }

        return ResponseFormatter::success("Chart Data:", $chartData, 200);
    }

}
