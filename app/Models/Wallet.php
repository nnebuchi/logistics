<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class Wallet extends Model
{
    use HasFactory;
    use BelongsToUser;

    protected $fillable = [
        "user_id",
        "balance"
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function transactions()
    {
        return $this->hasMany(
            Transaction::class, 
            "wallet_id"
        );
    }
}
