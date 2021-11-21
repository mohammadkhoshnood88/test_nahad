<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;
    
    protected $fillable = ['name' , 'address' , 'phone_number' , 'state_id' , 'city_id' , 'description' , 'location' , 'owner_name' , 'subject' , 'is_active' , 'is_pending' , 'is_delete'];
    
    public function images()
    {
        return $this->hasMany('App\Models\InsuranceImage');
    }

    public function tels()
    {
        return $this->hasMany('App\Models\InsuranceTel');
    }
    
    public function state(){
        return $this->belongsTo('App\Models\State');
    }
    
    public function city(){
        return $this->belongsTo('App\Models\City');
    }
    
    public function visits(){
        return $this->hasMany('App\Models\VisitAccessory' , 'post_id');
    }

}
