<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuxTel extends Model
{
    use HasFactory;

    protected $fillable = ['tel'];

    public function lux(){
        return $this->belongsTo('App\Models\Lux');
    }
}
