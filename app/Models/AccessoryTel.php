<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessoryTel extends Model
{
    use HasFactory;

    protected $fillable = ['tel'];

    public function accessory(){
        return $this->belongsTo('App\Models\Accessory');
    }
}
