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

class WalletController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);

        return view('customer.wallet', compact('user'));
    }

    public function getWallet()
    {
        $user = User::find(Auth::user()->id);
        $wallet = $user->wallet;
        $transactions = $wallet->transactions()->orderBy('created_at', 'desc')->get();
        $totalCredit = $wallet->transactions()
        ->where(['type' => 'Credit', 'status' => 'success'])->sum('amount');
        
        $data = [
            "wallet" => $wallet,
            "totalCredit" => $totalCredit,
            "transactions" => $transactions,
        ];
        return ResponseFormatter::success("Wallet Data:", $data, 200); 
    }

    private function storeTransaction($walletId, $amount): Transaction
    {
        $transaction = new Transaction();
        $transaction->wallet_id = $walletId;
        $transaction->amount = $amount;
        $transaction->type = "Credit";
        $transaction->purpose = "Wallet Top up";
        $transaction->reference = $this->generateReference($walletId);
        $transaction->save();

        return $transaction;
    }

    private function generateReference($id)
    {
        $token = "";
        $codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codeAlphabet .= 'abcdefghijklmnopqrstuvwxyz';
        $codeAlphabet .= '0123456789';
        $max = strlen($codeAlphabet) - 1;
        for($i=0; $i<14; $i++):
            $token .= $codeAlphabet[mt_rand(0, $max)]; 
        endfor; 
        return $id.strtolower($token);
    }

    public function createTransaction(Request $request)
    {
        $user = User::find($request["userId"]);
        $wallet = $user->wallet;
        $transaction = $this->storeTransaction($wallet->id, $request->amount);

        $data = [
            "key" => env('PAYSTACK_PUBLIC'),
            "email" => $user->email,
            "amount" => $transaction->amount,
            "reference" => $transaction->reference
        ];
        return ResponseFormatter::success("Payment Data:", $data, 200); 
    }

    public function fundWallet(Request $request)
    {
        $reference = $request["reference"];
        $transaction = Transaction::where(['reference' => $reference])->first();
        if(!$transaction) exit();
        if($transaction->verified) exit();

        $wallet = $transaction->wallet;

        $payment = new Paystack;
        $paymentData = $payment->getPaymentData($reference);

        if($paymentData["status"]):
            if($paymentData["data"]["status"] == "success"):
                $wallet->balance += $paymentData["data"]["amount"] / 100;
                $wallet->save();

                $transaction->status = "success";
                $transaction->verified = true;
                $transaction->save();

                return response()->json([
                    'message' => 'Funding Successful!',
                    "results" => null,
                    "error" => false
                ]);
            elseif($paymentData["data"]["status"] == "abandoned"):
                $transaction->status = "failed";
                $transaction->verified = true;
                $transaction->save();

                return response()->json([
                    'message' => 'Funding failed!',
                    "results" => null,
                    "error" => false
                ]);
            endif;
        endif;
    }
}