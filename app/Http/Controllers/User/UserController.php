<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Util\ResponseFormatter;
use App\Services\UserService;
use App\Http\Requests\ChangePassword;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $user = User::find(Auth::user()->id);

        return view('customer.index', compact('user'));
    }

    public function showShipments()
    {
        $user = User::find(Auth::user()->id);

        return view('customer.shipments', compact('user'));
    }

    public function showProfile()
    {
        $user = User::find(Auth::user()->id);

        return view('customer.profile.profile', compact('user'));
    }

    public function fetchNotifications()
    {
        $user = User::find(Auth::user()->id);

        $notifications = $user->notifications;

        return ResponseFormatter::success('Notifications', $notifications, 200);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_number' => 'sometimes|string',
            'utility_bill' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'valid_govt_id' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'business_cac' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->fails()):
            return response([
                'message' => "Failed to update profile",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        endif;

        return $this->userService->updateProfile($request);
    }

    public function changePassword(ChangePassword $request)
    {
        return $this->userService->changePassword($request->validated());
    }

}