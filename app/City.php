<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    function province(){
        return $this->belongsTo(Province::class);
    }

    function schools(){
        return $this->hasMany(School::class);
    }
}
