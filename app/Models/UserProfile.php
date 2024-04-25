<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Casts\Attribute;

class UserProfile extends Model
{
    use HasFactory;
    use BelongsToUser;

    protected $fillable = [
        "user_id",
        "utility_bill",
        "valid_govt_id",
        "business_cac",
        "id_number"
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected function validGovtId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_null($value) ? $value : json_decode($value),
            set: fn ($value) => $value
        );
    }
}