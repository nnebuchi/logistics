<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WebhookLog;
use App\Models\Transaction;
use App\Util\Paystack;
use App\Util\ResponseFormatter;
use Exception;

class WalletController extends Controller
{
    private Paystack $paystack;

    public function __construct(Paystack $paystack)
    {
        $this->paystack = $paystack;
    }

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

        //$payment = new Paystack();
        $paymentData = $this->paystack->getPaymentData($reference);
        $paymentData = json_decode($paymentData, true);

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
                $transaction->status = "pending";
                $transaction->verified = true;
                $transaction->save();

                return response()->json([
                    'message' => 'Funding abandoned!',
                    "results" => null,
                    "error" => false
                ]);
            elseif($paymentData["data"]["status"] == "failed"):
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

    public function paymentWebhook(Request $request)
    {
        http_response_code(200);

        // Log the webhook payload
        WebhookLog::create([
            'event' => $request['event'],
            'payload' => json_encode($request->all())
        ]);

        try{
            if($request['event'] == "charge.success"): //If charge was successful
                $reference = $request["data"]["reference"];
                $trx = Transaction::where(['reference' => $reference])->first();
                //if(!$trx) exit();
                if($trx && $trx->verified) exit();

                if($request["data"]["status"] == "success"):
                    $user = User::where(["email" => $request["data"]["customer"]["email"]])->first();
                    $wallet = $user->wallet;

                    $paymentData = $this->paystack->getPaymentData($reference);
                    $paymentData = json_decode($paymentData, true);
                    if($paymentData["status"]):
                        if($paymentData["data"]["status"] == "success"):
                            $wallet->balance += $paymentData["data"]["amount"] / 100;
                            $wallet->save();
                            
                            if($trx):
                                $trx->status = "success";
                                $trx->verified = true;
                                $trx->save();
                            else:
                                $transaction = new Transaction();
                                $transaction->wallet_id = $wallet->id;
                                $transaction->amount = $paymentData["data"]["amount"] / 100;
                                $transaction->type = "Credit";
                                $transaction->purpose = "Wallet Top up";
                                $transaction->reference = $reference;
                                $transaction->status = "success";
                                $transaction->verified = true;
                                $transaction->save();
                            endif;
                        elseif($paymentData["data"]["status"] == "failed"):
                            if($trx):
                                $trx->status = "failed";
                                $trx->verified = true;
                                $trx->save();
                            else:
                                $transaction = new Transaction();
                                $transaction->wallet_id = $wallet->id;
                                $transaction->amount = $paymentData["data"]["amount"] / 100;
                                $transaction->type = "Credit";
                                $transaction->purpose = "Wallet Top up";
                                $transaction->reference = $reference;
                                $transaction->status = "failed";
                                $transaction->verified = true;
                                $transaction->save();
                            endif;
                        endif;
                    endif;
                endif;
            endif;
        }catch (Exception $e) {
            // Log the error
            WebhookLog::create([
                'event' => $request['event'],
                'payload' => json_encode($request->all()),
                'error_message' => $e->getMessage()
            ]);
        }
    }
}