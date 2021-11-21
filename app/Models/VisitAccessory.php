<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitAccessory extends Model
{
    protected $fillable = ['ip' , 'post_id'];

    use HasFactory;
}
