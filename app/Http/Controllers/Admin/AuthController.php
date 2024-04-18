<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, Auth};
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
//use App\Http\Requests\ChangePassword;
use App\Http\Requests\RegisterRequest;

use App\Models\Admin;
use App\Services\AuthService;
use App\Util\ResponseFormatter;
use App\Util\Helper;

class AuthController extends Controller
{
    private AuthService $authService;
    protected $tokenName = 'admin-token';

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /*protected function redirectTo(Request $request)
    {
        if (!$request->expectsJson()) {
            return route('admin.login'); // Assuming your admin login route name is 'admin.login'
        }
    }*/

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /*public function showSignupForm()
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
    }*/

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = Admin::where(['email' => $data['email']])->first();

        if(!$user || !password_verify($data["password"], $user->password)):
            $message = "Oops, your email or password is incorrect";
            return ResponseFormatter::error($message, 400);
        elseif(!$user->hasVerifiedEmail()):
            $message = "Please Verify your email to login!";
            return ResponseFormatter::error($message, 401);
        /*elseif(!$user->hasRole('admin')):
            $message = "You are not authorized to access this resource";
            return ResponseFormatter::error($message, 401);*/
        endif;

        //delete user previous token ....single device auth only
        $this->deleteToken($user);
        $user->refresh();
        
        Auth::guard("admin")->login($user, true);
        $user = Auth::guard("admin")->user();
        $token = $this->generateToken($user);
        $user->token = $token;

        unset($user->tokens);

        $message = 'Login successfully';
        return ResponseFormatter::success(
            $message, 
            ["user" => $user, "redirect" => url('/admin')]
        );
    }


    public function logOut(Request $request)
    {
        //delete all previous user token
        $this->deleteToken(auth()->user());

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/admin/login");
    }

    private function generateToken($user)
    {
        return $user->createToken($this->tokenName)->plainTextToken;
    }

    private function deleteToken($user): void
    {
        $user->tokens->each(function ($token, $key) {
            $token->delete();
        });
    }

}
