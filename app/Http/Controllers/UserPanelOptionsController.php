<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\LadderPost;
use App\Models\Post;
use App\Models\PostExtras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Psy\bin;

class UserPanelOptionsController extends Controller
{
    public function urgent(Request $request)
    {
        $post = Post::where('id', '=', $request->id)->first();
        if (!isset($post)){
            return "in agahi nist";
        }
        $post->urgent = 1;
        $post->save();

    }

    public function vip(Request $request)
    {

    }

    public function ladder(Request $request)
    {

        $post = Post::where('id', '=', $request->id)->first();
        if (!isset($post)){
            return "in agahi nist";
        }

        $ladder = new Post;

        $ladder->cbrand_id = $post->cbrand_id;
        $ladder->image_path = $post->image_path;
        $ladder->cmodel_id = $post->cmodel_id;
        $ladder->year_id = $post->year_id;
        $ladder->gearbox_id = $post->gearbox_id;
        $ladder->distance = $post->distance;
        $ladder->color_id = $post->color_id;
        $ladder->cbody_id = $post->cbody_id;
        $ladder->price = $post->price;
        $ladder->subject = $post->subject;
        $ladder->phone_number = $post->phone_number;
        $ladder->email = $post->email;
        $ladder->description = $post->description;
        $ladder->state_id = $post->state_id;
        $ladder->city_id = $post->city_id;
        $ladder->location = $post->location;
        $ladder->type = $post->type;
        $ladder->meta = $post->meta;
        $ladder->trending = $post->trending;
        $ladder->is_rent = $post->is_rent;
        $ladder->instagram_id = $post->instagram_id;
        $ladder->website = $post->website;
        $ladder->save();

        $images = Image::all()->where('post_id', '=', $request->id);

        foreach ($images as $img){
            $img->post_id = $ladder->id;
            $img->save();
        }
        $post->delete();

        $ladder_post = new LadderPost();
        $ladder_post->old_id = $post->id;
        $ladder_post->new_id = $ladder->id;
        $ladder_post->save();

        $extras = $this->set_option("ladder" , $ladder_post->id , $ladder->id , $ladder->mobile);

        return "ok";

    }

    public function re_active(Request $request)
    {

    }

    public function remove_option(Request $request)
    {
        $option = PostExtras::all()->where('id' , '=' , $request->id)->first();
        if ($option == "instagram" || $option == "website"){

            $post = Post::all()->where('post_id' , '=' , $option->post_id)->first();
            if ($option == "instagram")
                $post->instagram = null;
            if ($option == "website")
                $post->website = null;

            $post->save();
        }
        $option->delete();

        return response()->json(['success' => true]);
    }
    
    public function upgrade(Request $request)
    {
    
        $oldex = PostExtras::all()->where('post_id' , '=' , $request->post_id);
        $mobile = session()->get('phone_number');
        $options = ['ladder' , 'urgent' , 'special' , 're_active'];
        

        foreach ($options as $option){

            if (isset($request[$option])){
                $old = $oldex->where('option_name' , '=' , $option);
                $dont_pay = $old->where('payment' , '=' , 0)->count();
                $paid = $old->where('payment' , '!=' , 0)->count();

                if ($dont_pay == 0)
                    $this->set_option($option , $paid + 1 , $request->post_id , $mobile);
            }

        }
        
      
        return redirect("/userpanel/financial/post/$request->post_id/cart");

    }


    public function set_option($option , $id , $post_id , $mobile)
    {
        $bind = [
            'mobile' => $mobile
        ];
        $user_id = DB::select("
        select id
        from user_panels
        where phone_num = :mobile
        " , $bind);

        $post_extras = new PostExtras();
        $post_extras->user_id = $user_id[0]->id;
        $post_extras->post_id = $post_id;
        $post_extras->option_name = $option;
        $post_extras->option_id = $id;
        $post_extras->payment = 0;
        $post_extras->save();

        return $post_extras->id;
    }

}
