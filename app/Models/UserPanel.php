<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserPanel extends Authenticatable implements JWTSubject
{
    public function post(){
        return $this->hasMany('App\Models\Post');
    }

    public function image(){
        return $this->hasMany('App\Models\Image');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
