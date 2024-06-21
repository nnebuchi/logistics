<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Parcel extends Model
{
    use HasFactory;

    protected $fillable = [
        "shipment_id",
        "external_parcel_id",
        "weight",
        "weight_unit",
        "metadata"
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $with = ["items"];

    protected function metadata(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_null($value) ? $value : json_decode($value),
            set: fn ($value) => json_encode($value)
        );
    }

    public function items()
    {
        return $this->hasMany(Item::class, "parcel_id");
    }
}
