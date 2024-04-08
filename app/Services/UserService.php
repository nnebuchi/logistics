<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Auth, Hash, Mail};
use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use App\Util\ResponseFormatter;
use Carbon\Carbon;

class UserService
{
    public function createUser($data)
    {
        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'account_id' => 1
        ]);

        return $user;
    }

    public function getUser()
    {
        $user = User::find(Auth::user()->id);
        
        return ResponseFormatter::success("User Data:", $user, 200);
    }

    public function updateUserProfile($data)
    {
        $user = User::find(Auth::user()->id);
        if($user->user_type == "doctor"):
            return ResponseFormatter::error("you are not allowed to access this resource", 400);
        endif;
        $userProfile = $user->profile;
        
        $images = ["photo", "medical_history"];
        foreach($images as $image):
            if($data->hasFile($image)):
                $photo = $data->file($image);
                $response = \Cloudinary\Uploader::upload($photo);
                $url = $response["url"];
                $userProfile->{$image} = $url;
            endif;
        endforeach;

        foreach($data->all() as $param => $value):
            if($param != "photo" && 
                $param != "medical_history" 
            ):
                $userProfile->{$param} = $value;
            endif;
        endforeach;
        $userProfile->save();

        return ResponseFormatter::success("Profile Updated", $user->fresh(), 200);
    }

    public function subscribe($data)
    {
        try{
            $user = User::find(Auth::user()->id);
            if($user->user_type == "doctor"):
                return ResponseFormatter::error("you are not allowed to access this resource", 400);
            endif;
    
            $plan = Plan::find($data["planId"]);
            $transaction = $this->createTransaction($user->id, $plan->amount, $plan->id);
            $url = $this->generatePaymentUrl($user, $transaction->amount, $transaction->reference, $plan->code);
            
            return ResponseFormatter::success("Payment Link:", $url, 200); 
        }catch(\Exception $e){
            $message = $e->getMessage();
            return ResponseFormatter::error("Oops!, unable to subscribe");
        }
    }

    private function createTransaction($userId, $amount, $planId): Transaction
    {
        $transaction = new Transaction();
        $transaction->user_id = $userId;
        $transaction->amount = $amount;
        $transaction->plan_id = $planId;
        $transaction->reference = $this->generateReference($userId);
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

    public function generatePaymentUrl($user, $total, $reference, $plan)
    {
        $response = (new Paystack())->initiateDeposit(
            $user->email, $total, $reference, $plan
        );

        return $response['data']["authorization_url"];
    }

    public function changePassword($data)
    {
        $user = User::find(auth()->user()->id);
        try{
            if((Hash::check($data["current_password"], $user->password)) == false):
                $message = "Check your old password.";
            elseif((Hash::check($data["password"], $user->password)) == true):
                $message = "Please enter a password which is not similar to your current password.";
            else:
                $user->password = $data["password"];
                $user->save();

                $message = "Your password has been changed successfully";
                return ResponseFormatter::success($message, null);
            endif;
        }catch(\Exception $e){
            $error_message = $e->getMessage();
            return ResponseFormatter::error($error_message);
        }
        
        return ResponseFormatter::error($message, 400);
    }

}