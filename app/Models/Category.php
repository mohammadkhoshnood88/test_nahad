<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['text'];

    public function blogs()
    {
        return $this->belongsToMany('App\Models\Blog');
    }
}
