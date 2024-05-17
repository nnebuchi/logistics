<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{URL, Password, DB, Mail, Auth, Validator};
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
//use App\Http\Requests\ChangePassword;
use App\Http\Requests\RegisterRequest;
use App\Models\Admin;
use App\Services\AuthService;
use App\Util\ResponseFormatter;
use App\Util\Helper;
use App\Rules\ContainsNumber;
use App\Rules\HasSpecialCharacter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private AuthService $authService;
    protected $tokenName = 'admin-token';

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
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

    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:admins,email'
        ]);

        if($validator->fails()):
            return response([
                'message' => "unable to reset password...",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        endif;

        $status = Password::broker('admins')->sendResetLink(['email' => $request['email']]);

        if ($status === Password::RESET_LINK_SENT) {
            return ResponseFormatter::success(
                'Password reset email has been sent, Please check your email.',
                null,
                200
            );
        } else {
            return ResponseFormatter::error(
                //'Failed to send password reset email.',
                ['email' => __($status)],
                400
            );
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:admins,email',
            'token' => 'required',
            'password' => [
                'required', 
                'confirmed',
                'string', 
                'min:8', 
                new HasSpecialCharacter, 
                new ContainsNumber
            ],
            'password_confirmation' => 'required|min:8'
        ]);

        if($validator->fails()):
            return response([
                'message' => "unable to reset password...",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        endif;

        $status = Password::broker('admins')->reset(
            [
                'email' => $request['email'],
                'password' => $request['password'],
                'confirm_password' => $request['password_confirmation'],
                'token' => $request['token']
            ],
            function (Admin $admin, string $password) {
                $admin->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));
     
                $admin->save();
    
                event(new PasswordReset($admin));
            }
        );
        
        return $status === Password::PASSWORD_RESET
        ? ResponseFormatter::success(
            'Password has been changed successfully.', 
            url("/password-change-success"), 
            200
        )
        : ResponseFormatter::error(
            ['email' => [__($status)]],
            422
        );

        return ResponseFormatter::success(
            'Password has been changed successfully.', 
            url("/password-change-success"), 
        200);
    }

}
