<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    public function kosts()
    {
        return $this->belongsTo(Kost::class);
    }
}
