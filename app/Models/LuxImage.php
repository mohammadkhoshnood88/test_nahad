<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuxImage extends Model
{
    use HasFactory;

    protected $fillable = ['path'];

    public function lux(){
        return $this->belongsTo('App\Models\Lux');
    }
}
