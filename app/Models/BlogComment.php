<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $fillable = ['blog_id' , 'user_name' , 'text' , 'email' , 'status' , 'response'];

    public function blog(){

        return $this->belongsTo('App\\models\Blog');

    }
}
