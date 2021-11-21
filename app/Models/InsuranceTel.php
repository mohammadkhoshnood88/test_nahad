<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceTel extends Model
{
    use HasFactory;

    protected $fillable = ['tel'];

    public function insurance(){
        return $this->belongsTo('App\Models\Insurance');
    }
}
