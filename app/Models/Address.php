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

    public function nation(){
        return $this->belongsTo(Country::class, 'country', 'sortname');
    }

    public function hostState(){
        return $this->belongsTo(State::class, 'state', 'name');
    }

    public function hostCity(){
        return $this->belongsTo(city::class, 'city', 'name');
    }


}
