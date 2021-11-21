<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\PostExtras;

class Financial
{
    private static $instance = null;
    
    public static function getInstance()
        {
            if (self::$instance == null)
        {
            self::$instance = new Financial();
        }
 
            return self::$instance;
        }
        
    public function AddPostExtras($user , $id , $option){
        
        $post_extras = new PostExtras();
        $post_extras->user_id = $user;
        $post_extras->post_id = $id;
        $post_extras->option_name = $option;
        $post_extras->option_id = 0;
        $post_extras->payment = 0;

        if($post_extras->save())
            return true;
        return false;   
    
    }

}