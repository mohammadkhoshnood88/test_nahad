<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechCheckUp extends Model
{
    protected $fillable = ['state_id' , 'city_id' , 'name' , 'address' , 'tel'];

    public function state()
    {
        $tech = TechCheckUp::find($this->id);
        $tech_state = $tech->state_id;
        $state = State::find($tech_state);
        return $state->name;

    }

    public function city()
    {
        $tech = TechCheckUp::find($this->id);
        $tech_city = $tech->city_id;
        $city = City::find($tech_city);
        return $city->name;

    }

    public function states()
    {
        $tech = TechCheckUp::find($this->id);
        $tech_state = $tech->state_id;
        $state = State::find($tech_state);
        $techs = TechCheckUp::all()->where('state_id' , '=' , $state->id);
        return $techs;

    }
}
