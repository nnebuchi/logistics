<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class TicketResponse extends Model
{
    use HasFactory;
    use BelongsToUser;

    protected $fillable = [
        "admin_id",
        "user_id",
        "ticket_id",
        "body"
    ];

    protected $hidden = ['updated_at'];

    protected $with = ["user", "admin"];

    public function admin()
    {
        return $this->belongsTo(Admin::class, "admin_id");
    }
}
