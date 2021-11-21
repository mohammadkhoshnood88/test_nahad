<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarIntro extends Model
{
    use HasFactory;
    
    public function cmodel(){
        return $this->belongsTo('App\Models\Cmodel' , 'model_id');
    }
}
