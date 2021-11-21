<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;

class PostExtras extends Model
{
    use HasFactory;
    
    public function post(){
        return $this->belongsTo('App\Models\Post');
    }
    
    public function invoice(){
        
        $payment = Payment::where('id' , $this->payment)->first();
        return $payment;
        
    
    }
    
}
