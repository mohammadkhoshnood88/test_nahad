<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Type extends Model
{
    public function meta()
    {
        $metas = VehicleMeta::all()->where('type_id' , '=' , "1");
        return $metas->sortBy('value');
    }

    public function posts()
    {
        $a = url()->current();
        $rent = 0;
        if(str_contains($a, 'rent'))
            $rent = 1;
            
        $bind = ['rent' => $rent , 'typ' => $this->id];
        $posts = DB::select("
        select id
        from posts
        where is_active = 1 and is_delete = 0 and is_rent = :rent and posts.type = :typ" , $bind);

        return $posts;

        // $posts = Post::all()->where('type' , '=' , $this->id)->where('is_rent' , '=' , $rent)
        // ->where('is_active' , '=' , 1)->where('is_delete' , '=' , 0);
        // return $posts;
    }
}
