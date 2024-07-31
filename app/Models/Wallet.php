<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Wallet extends Model
{
    use HasFactory;
    use BelongsToUser;

    protected $fillable = [
        "user_id",
        "balance"
    ];

    protected $hidden = [
        'created_at',
        //'updated_at'
    ];

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/y'),
            set: fn ($value) => $value
        );
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, "wallet_id");
    }
}
