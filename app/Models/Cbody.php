<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cbody extends Model
{
    public function post(){
        return $this->hasMany('App\Models\Post');
    }
}
