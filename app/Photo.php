<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['photo', 'kost_id'];
    protected $table = 'photo';
}
