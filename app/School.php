<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    function city(){
        return $this->belongsTo(City::class);
    }
}
