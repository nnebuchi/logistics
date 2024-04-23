<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

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
}