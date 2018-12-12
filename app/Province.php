<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    function country(){
        return $this->belongsTo(Country::class);
    }
}
