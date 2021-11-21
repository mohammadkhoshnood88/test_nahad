<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public function post(){
        return $this-> hasMany('App\Models\Post');
    }
}
