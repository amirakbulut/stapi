<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    function provinces(){
        return $this->hasMany(Province::class);
    }
}
