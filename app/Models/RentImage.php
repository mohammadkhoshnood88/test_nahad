<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentImage extends Model
{
    public function rent(){
        return $this->belongsTo('App\Models\Rent', 'Rent_id', 'id');
    }
}
