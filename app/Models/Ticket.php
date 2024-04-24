<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "subject",
        "body",
        "status",
        //"attachments"
    ];

    protected $hidden = ['updated_at'];

    protected $with = ["responses"];

    public function responses()
    {
        return $this->hasMany(TicketResponse::class, "ticket_id");
    }

}
