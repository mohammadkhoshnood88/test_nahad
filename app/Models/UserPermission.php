<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    static $role_name = [

    ];
    protected $fillable = ['user_id' , 'role'];


    public function user(){

        return $this->belongsTo('App\Models\User');

    }

}
