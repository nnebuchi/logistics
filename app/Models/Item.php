<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        "shipment_id",
        "parcel_id",
        "name",
        "description",
        "currency",
        "value",
        "quantity",
        "weight"
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function shipment(){
        return $this->belongsTo(Shipment::class);
    }

    public function parcel(){
        return $this->belongsTo(Parcel::class);
    }

}
