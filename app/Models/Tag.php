<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'text',
        'url'
    ];

    public function blogs()
    {
        return $this->belongsToMany('App\Models\Blog');
    }
}
