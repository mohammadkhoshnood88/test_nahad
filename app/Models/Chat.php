<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function mobile(){
        
        $bind = ['id' => $this->user_id];
        
        $mobile = DB::select("
        select phone_num
        from user_panels
        where id = :id
        ", $bind);
        
        return $mobile[0]->phone_num;
    }
}
