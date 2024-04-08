<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Transaction extends Model
{
    use HasFactory;
    use BelongsToUser;

    protected $fillable = [
        "user_id",
        "wallet_id",
        "amount",
        "type",
        "status",
        "reference",
        "verified"
    ];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            //get: fn ($value) => Carbon::parse($value)->format('M j, Y g:ia')
            get: fn ($value) => Carbon::parse($value)->toFormattedDateString(),
            set: fn ($value) => $value
        );
    }

    protected function verified(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($value == 0) ? false : true,
            set: fn ($value) => $value
        );
    }

    public function shipments()
    {
        return $this->hasOne(
            Shipping::class, 
            "transaction_id"
        );
    }
}
