<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentOffer extends Model
{
    protected $fillable = ['phone_number' , 'email' , 'state_id' , 'city_id' , 'subject' , 'model' , 'description'];


    public function city_name()
    {
        $city = City::all()->where('id' , '=' , $this->city_id)->first();
        return $city->name;
    }

    public function state_name()
    {
        $state = State::all()->where('id' , '=' , $this->state_id)->first();
        return $state->name;
    }

    public function type_name()
    {
        $type = Type::all()->where('id' , '=' , $this->type)->first();
        return $type->name;
    }

    // public function driver_status($status)
    // {
    //     return $status;
    // }

}
