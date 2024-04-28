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
    public function getUser()
    {
        $user = User::find(Auth::user()->id);
        
        return ResponseFormatter::success("User Data:", $user, 200);
    }

    public function updateProfile($data)
    {
        $user = User::find(Auth::user()->id);
        $userProfile = $user->profile;
        $valid_govt_id = [];
        $images = ["photo", "utility_bill", "valid_govt_id", "business_cac"];
        foreach($images as $image):
            if($data->hasFile($image)):
                if(is_array($data->file($image))):
                    foreach($data->file($image) as $validId):
                        $url = cloudinary()
                        ->upload($validId->getRealPath())->getSecurePath();
                        array_push($valid_govt_id, $url);
                    endforeach;
                    $userProfile->{$image} = json_encode($valid_govt_id);
                else:
                    $photo = $data->file($image);
                    $url = cloudinary()
                    ->upload($photo->getRealPath())->getSecurePath();
                    if($image == "photo"):
                        $user->{$image} = $url;
                    else:
                        $userProfile->{$image} = $url;
                    endif;
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