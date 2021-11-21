<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blogimge extends Model
{
    protected $fillable =
        [
            'blog_id',
            'address',
            'index_id'
        ];

    public function blog()
    {

        return $this->belongsTo('App\Models\Blog');

    }

}
