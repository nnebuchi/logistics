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

    public function updateProfile($data)
    {
        $user = User::find(Auth::user()->id);
        $userProfile = $user->profile;
        
        $images = ["photo", "utility_bill", "valid_govt_id", "business_cac"];
        foreach($images as $image):
            if($data->hasFile($image)):
                $photo = $data->file($image);
                $url = cloudinary()
                ->upload($photo->getRealPath())->getSecurePath();
                if($image == "photo"):
                    $user->{$image} = $url;
                else:
                    $userProfile->{$image} = $url;
                endif;
            endif;
        endforeach;

        foreach($data->all() as $param => $value):
            if($param != "photo" && 
                $param != "utility_bill" && 
                $param != "valid_govt_id" && 
                $param != "business_cac"
            ):
                $userProfile->{$param} = $value;
            endif;
        endforeach;
        $user->save();
        $userProfile->save();

        return ResponseFormatter::success("Profile Updated", $user->fresh(), 200);
    }

}