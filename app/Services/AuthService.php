<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{URL, Password, DB, Mail, Auth};
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
//use App\Http\Resources\UserResource;
//use App\Services\UserService;
//use App\Services\{FileService};
use App\Mail\VerifyAccountMail;
use App\Mail\PasswordResetMail;
use App\Mail\WelcomeMail;
use App\Util\ResponseFormatter;
use App\Models\{User, Role, Account};
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;

class AuthService 
{
    protected $tokenName = 'user-token';

    public function register($data){
        //create user
        $result =  DB::transaction(function() use($data){
            $account = Account::where(['name' => $data['account_type']])->first();

            $user = User::create([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => $data['password'],
                'account_id' => $account->id
            ]);    

            $user->wallet()->create();
            //$user->profile()->create();
            
            event(new Registered($user));

            //Auth::guard("web")->login($user, true);
            Auth::login($user, true);

            return $user;
        });
        return ResponseFormatter::success(
            "Registration Successful, Please verify your email!", 
        url("/email/verify"), 201);
    }

    public function login($data){
        $user = User::where(['email' => $data['email']])->first();

        if(!$user || !password_verify($data["password"], $user->password)):
            $message = "Oops, your email or password is incorrect";
            return ResponseFormatter::error($message, 400);
        /*elseif(!$user->hasVerifiedEmail()):
            $message = "Please Verify your email to login!";
            return ResponseFormatter::error($message, 401);*/
        endif;
        
        //delete user previous token ....single device auth only
        $this->deleteToken($user);
        $user->refresh();
        
        //Auth::guard("web")->login($user, true);
        Auth::login($user, true);
        $user = Auth::user();
        $token = $this->generateToken($user);
        $user->token = $token;

        unset($user->tokens);

        $message = 'Login successfully';
        return ResponseFormatter::success(
            $message, 
            ["user" => $user, "redirect" => url('')]
        );
    }

    public function logOut(Request $request)
    {
        //delete all previous user token
        $this->deleteToken(auth()->user());

        //Auth::guard("user")->logout();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/login");
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

    public function forgotPassword($data)
    {
        $status = Password::sendResetLink(["email" => $data["email"]]);
        /*return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);*/
    
        return ResponseFormatter::success(
            'Password reset email has been sent, Please check your email.', 
            null, 
        200);
    }

    public function resetPassword($data)
    {
        $status = Password::reset(
            [
                "email" => $data["email"],
                "password" => $data["password"],
                "confirm_password" => $data["password_confirmation"],
                "token" => $data["token"],
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
        
        /*return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);*/

        return ResponseFormatter::success(
            'Password has been changed successfully.', 
            url("/password-change-success"), 
        200);
    }
    
}