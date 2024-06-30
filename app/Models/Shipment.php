<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "external_shipment_id",
        "status",
        "pickup_date"
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // protected $with = ["address_from", "address_to", "parcels", "items"];

    protected function pickupDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_null($value) ? $value : Carbon::parse($value)->format('d/m/y'),
            set: fn ($value) => $value
        );
    }

    public function address_from()
    {
        return $this->hasOne(Address::class, "shipment_id", "id")->where("type", "from");
    }

    public function address_to()
    {
        return $this->hasOne(Address::class, "shipment_id", "id")->where("type", "to");
    }

    public function items()
    {
        return $this->hasMany(Item::class, "shipment_id");
    }

    public function parcels()
    {
        return $this->hasMany(Parcel::class, "shipment_id");
    }

    public function address(){
        return $this->hasMany(Address::class, );
    }

    public function attachments(){
        return $this->hasManyThrough(Attachment::class, Parcel::class);
    }

}
