<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Util\Helper;
use Illuminate\Support\Facades\{Validator, Auth};
use App\Util\ResponseFormatter;
use Spatie\Permission\Models\Role;
use App\Rules\ContainsNumber;
use App\Rules\HasSpecialCharacter;
use Illuminate\Validation\Rule;
use App\Notifications\SendCustomerNotification;
use App\Notifications\SendInvoice;

class AdminController extends Controller
{
    public function createAdmin(Request $request){
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'email' => 'required|email|max:200|unique:admins',
            'phone' => [
                'required',
                //'regex:/^\+(\d{1,4})\d{7,14}$/', 
                'unique:admins'
            ],
            'role' => 'required|numeric',
            'password' => ['required', 'string', 'min:8', new HasSpecialCharacter, new ContainsNumber]
        ]);

        if($validator->fails()):
            return response([
                'message' => "unable to add new admin...",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        endif;

        $admin = new Admin;
        $admin->firstname = $request->firstname;
        $admin->lastname = $request->lastname;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->password = $request->password;
        $admin->save();

        // Find the role by name
        $role = Role::where('id', $request->role)->first();
        // Assign the role to the user
        $admin->assignRole($role);

        $admins = Admin::all();

        return ResponseFormatter::success("admin:", $admins, 200);
    }

    public function updateAdmin(Request $request, $adminId){
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:200',
                Rule::unique('admins')->ignore($adminId)
            ],
            'phone' => [
                'required',
                //'regex:/^\+(\d{1,4})\d{7,14}$/',
                Rule::unique('admins')->ignore($adminId)
            ],
            'role' => 'required|numeric'
        ]);

        if($validator->fails()):
            return response([
                'message' => "unable to update new admin...",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        endif;

        $admin = Admin::find($adminId);
        $admin->firstname = $request->firstname;
        $admin->lastname = $request->lastname;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->save();

        $admins = Admin::all();

        return ResponseFormatter::success("admin:", $admins, 200);
    }

    public function updateUserVirtualAccount(Request $request, $userId){
        $user = User::find($userId);

        $wallet = $user->wallet;
        $wallet->bank_name = $request["bank_name"];
        $wallet->account_name = $request["account_name"];
        $wallet->account_number = $request["account_number"];
        $wallet->save();

        return ResponseFormatter::success("Customer virtual account has been updated:", null, 200);
    }

    public function broadcastToCustomer(Request $request){
        $validator = Validator::make($request->all(), [
            'recipient' => 'required|string',
            'title' => 'required|string',
            'message' => 'required|string',
        ]);

        if($validator->fails()):
            return response([
                'message' => "Oops!, error in sending push notifications",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        endif;

        $notificationData = [
            "title" => $request["title"],
            "message" => $request["message"]
        ];

        switch($request["recipient"]):
            case "all":
                $users = User::all();
                foreach($users as $user):
                    $user->notify(new SendCustomerNotification($notificationData));
                endforeach;
                $message = "notifications has been sent to all users";
            break;
            default:
                $user = User::find($request["recipient"]);
                $user->notify(new SendCustomerNotification($notificationData));
                $message = "notifications has been sent to ".$user->name;
            break;
        endswitch;

        return ResponseFormatter::success($message, null, 200);
    }

    public function verifyCustomerAccount($uuid)
    {
        $user = User::where("uuid", $uuid)->first();
        if($user):
            $user->is_verified = true;
            $user->save();

            return redirect('/admin/users/'.$user->uuid);
        endif;
    }


}
