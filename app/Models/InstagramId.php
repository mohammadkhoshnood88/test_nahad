<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramId extends Model
{
    use HasFactory;
    
    protected $fillable = ['post_id' , 'instagram_id'];
}
