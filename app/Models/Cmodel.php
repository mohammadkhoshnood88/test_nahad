<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cbrand;

class Cmodel extends Model
{
    public function cbrand(){
        return $this->belongsTo('App\Models\Cbrand');
    }
    public function post(){
        return $this->hasMany('App\Models\Post');
    }
    public function intro(){
        return $this->hasOne('App\Models\CarIntro', 'model_id');
    }    
    
}
