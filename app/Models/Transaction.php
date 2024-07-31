<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        "wallet_id",
        "purpose",
        "amount",
        "type",
        "status",
        "reference",
        "verified"
    ];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('M j, Y g:ia'),
            //get: fn ($value) => Carbon::parse($value)->format('d/m/y'),
            set: fn ($value) => $value
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('M j, Y g:ia'),
            //get: fn ($value) => Carbon::parse($value)->format('d/m/y'),
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
        return $this->hasOne(Shipment::class, "transaction_id");
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, "wallet_id");
    }
}
