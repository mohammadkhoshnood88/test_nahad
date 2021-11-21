<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cbrand extends Model
{
    public function cmodel(){
        return $this->hasMany('App\Models\Cmodel');
    }
    public function post(){
        return $this->hasMany('App\Models\Post');
    }
}
