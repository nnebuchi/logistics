<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        "transaction_id",
        "status",
        "date",
        "tracking_code"
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
