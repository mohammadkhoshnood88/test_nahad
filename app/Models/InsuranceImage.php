<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceImage extends Model
{
    use HasFactory;

    protected $fillable = ['path'];

    public function insurance(){
        return $this->belongsTo('App\Models\Insurance');
    }
}
