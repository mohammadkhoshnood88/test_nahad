<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentPersonalInfo extends Model
{
    use HasFactory;

    protected $fillable = ['id' , 'name' , 'description' , 'surname' , 'national_code' , 'mobile' , 'address' , 'active' , 'admin_comment'];


    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

}
