<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    public $timestamps = false;

    const _PERSONAL = "personal";
    const _BUSINESS = "business";
    const _3PL = "3pl";

    protected $fillable = [
        'name',
        'description'
    ];

    protected $hidden = [
        'description'
    ];

    public function users()
    {
        return $this->hasMany(
            User::class, 
            "account_id"
        );
    }
}