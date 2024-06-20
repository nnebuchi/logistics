<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    use HasFactory;

    protected $fillable = [
        "shipment_id",
        "external_parcel_id",
        "weight",
        "weight_unit"
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $with = ["items"];

    public function items()
    {
        return $this->hasMany(Item::class, "parcel_id");
    }
}
