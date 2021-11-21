<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function city(){
        return $this->hasMany('App\Models\City');
    }
    public function post(){
        return $this->hasMany('App\Models\Posts');
    }

    public function techs()
    {
        $state = State::find($this->id);

        $techs = TechCheckUp::all()->where('state_id' , '=' , $state->id);
        return $techs;

    }

}
