<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    public function image(){
        return $this->hasMany('App\Models\RentImage');
    }

    public function type_name()
    {
        $type = Type::all()->where('id' , '=' , $this->type)->first();
        return $type->name;
    }
}
