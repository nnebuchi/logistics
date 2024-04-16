<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator};
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
//use App\Http\Requests\ChangePassword;
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
        return view('admin.auth.login');
    }

    public function showSignupForm()
    {
        $data['accounts'] = Account::get();

        return view('admin.auth.register')->with($data);
    }

    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function showPasswordResetForm($email, $token)
    {
        return view('admin.auth.reset-password', [
            "email" => $email,
            "token" => $token
        ]);
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request->validated());
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

}
