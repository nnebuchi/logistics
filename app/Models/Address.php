<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        "shipment_id",
        "firstname",
        "lastname",
        "email",
        "phone",
        "country",
        "state",
        "city",
        "zip",
        "line1",
        "type"
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

}
