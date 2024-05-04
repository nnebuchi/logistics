<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator};
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\RegisterRequest;

use App\Models\Account;
use App\Services\AuthService;
use App\Util\ResponseFormatter;
use App\Util\Helper;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('customer.auth.login');
    }

    public function showSignupForm()
    {
        $data['accounts'] = Account::get();

        return view('customer.auth.register')->with($data);
    }

    public function showForgotPasswordForm()
    {
        return view('customer.auth.forgot-password');
    }

    public function showPasswordResetForm($email, $token)
    {
        return view('customer.auth.reset-password', [
            "email" => $email,
            "token" => $token
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        return $this->authService->login($request);
    }

    public function logOut(Request $request)
    {
        return $this->authService->logOut($request);
    }

    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request->validated());
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if($validator->fails()):
            return response([
                'message' => "Password Reset failed",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        endif;

        return $this->authService->forgotPassword($request->all());
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->authService->resetPassword($request->validated());
    }

    public function test(){
        //return view('customer.auth.email-verification-success');
        //return view('vendor.notifications.verify-email');
        //return view('customer.auth.verify-email');
        return Helper::userPercentageChange();
    }

}
