<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function post(){
        return $this->belongsTo('App\Models\Post', 'Post_id', 'id');
    }

    public function userpanel(){
        return $this->belongsTo('App\Models\UserPanel', 'Post_id', 'id');
    }
}
