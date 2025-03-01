<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lab404\Impersonate\Models\Impersonate;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Impersonate;

    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'email',
        'password',
        'account_id',
        'email_verified_at',
        'photo',
        'address',
        'country',
        'is_verified',
        'uuid'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'account_id'
    ];

    protected $with = ["account", "profile"];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Send a password reset notification to the user.
     * @param string $token
    */
    public function sendPasswordResetNotification($token): void
    {
        $url = env("APP_URL")."/reset-password/".$this->email."/".$token;

        $this->notify(new ResetPasswordNotification($url));
    }

    protected function firstname(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => ucwords(strtolower($value))
        );
    }

    protected function lastname(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => ucwords(strtolower($value))
        );
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => strtolower($value),
        );
    }

    protected function isVerified(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value == 0) ? false : true,
            set: fn ($value) => $value
        );
    }

    public function account()
    {
        return $this->belongsTo(Account::class, "account_id");
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, "user_id");
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class, "user_id");
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class, "user_id");
    }

}
