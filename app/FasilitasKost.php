<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FasilitasKost extends Model
{
    protected $table = 'fasilitas_kost';
    protected $fillable = ['fasilitas_id', 'kost_id'];

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }
}
