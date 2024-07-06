<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Staudenmeir\EloquentHasManyDeep\BelongsToThrough;
use \Znck\Eloquent\Traits\BelongsToThrough;

class Attachment extends Model
{
    use HasFactory;
    use BelongsToThrough;


    public function parcel(){
        return $this->belongsTo(Parcel::class);
    }

    public function shipment(){
        return $this->belongsToThrough(Shipment::class, [Parcel::class]);
    }
}
