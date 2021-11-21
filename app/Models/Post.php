<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Post extends Model
{
    
    protected $fillable = ['phone_number' , 'image_path' , 'email' , 'state_id' , 'city_id' , 'location' , 'subject' , 'description' , 'cbody_id' , 'year_id' , 'type' ,
                            'is_rent' , 'cbrand_id' , 'cmodel_id' , 'gearbox_id' , 'color_id' , 'distance' , 'price' , 'trending' , 'driver_status' , 'workers'];
    
    public function image(){
        return $this->hasMany('App\Models\Image');
    }
    public function cmodel(){
        return $this->belongsTo('App\Models\Cmodel');
    }
    public function cbrand(){
        return $this->belongsTo('App\Models\Cbrand');
    }
    public function state(){
        return $this->belongsTo('App\Models\State');
    }
    public function city(){
        return $this->belongsTo(City::class , 'city_id');
//        return $this->belongsTo('app\City');
    }
    public function gearbox(){
        return $this->belongsTo('App\Models\Gearbox');
    }
    public function color(){
        return $this->belongsTo('App\Models\Color');
    }
    public function year(){
        return $this->belongsTo('App\Models\Year');
    }

    public function cbody(){
        return $this->belongsTo('App\Models\Cbody');
    }

    public function userpanel(){
        return $this->belongsTo('App\Models\UserPanel');
    }

    public function type_name()
    {
        return $this->belongsTo('App\Models\Type' , 'type');
    }

    public function tonnage_name()
    {
        $meta = VehicleMeta::all()->where('id' , '=' , $this->meta)->first();
        if ($meta)
        {
            return $meta->value;
        }
        else{ return "";}

    }

    public function meta_type()
    {
        $meta = VehicleMeta::all()->where('id' , '=' , $this->meta)->first();

        if ($meta)
        {
            switch ($meta->key) {
                case("tonnage"):
                    $val = "تن";
                    break;
                case("wheel"):
                    $val = "چرخ";
                    break;
                default :
                    $val = "";

            }
            return $val;
        }
        else{ return "";}
    }

    public function index($index)
    {
        $images = Image::where('post_id'  , $this->id)->get();
        $count_images = count($images);
        if ($index >= $count_images)
            return "";

        return $images[$index]->path;
    }

    public function city_name()
    {
        $city = City::all()->where('id' , '=' , $this->city_id)->first();
        return $city->name;
    }

    public function brand_desc()
    {
        $desc = Cbrand::all()->where('id' , '=' , $this->cbrand_id)->first();
        return $desc->description;
    }
    
    public function visits()
    {
        $bind = [
            'id' => $this->id
        ];
        $visits = DB::select("
        select ip
        from visits
        where post_id = :id
        ", $bind);
        
        if(count($visits) > $this->visit_count)
            return count($visits);
        else
            return $this->visit_count;
        
    }
    
    public function is_ladder()
    {
        $bind = [
            'id' => $this->id
        ];
        $ladder = DB::select('
        select post_id
        from ladder_posts
        where post_id = :id 
        ' , $bind);

        return count($ladder);
    }
    
    public function get_instagram()
    {
        // use raw query for increase speed of load instagram id
        if(isset($this->instagram_id))
            return $this->instagram_id;
        else{
        $bind = [
            'id' => $this->id
        ];
        $val = DB::select('
        select instagram_id
        from instagram_ids
        where post_id = :id 
        ' , $bind);
                
            return (count($val) == 1 ? $val[0]->instagram_id : "");
        }
            
    }
    
    public function get_website()
    {

        if(isset($this->website))
            return $this->website;
        else{
                    $bind = [
            'id' => $this->id
        ];
        $val = DB::select('
        select website
        from web_sites
        where post_id = :id 
        ' , $bind);
        
        return (count($val) == 1 ? $val[0]->website : "");
        }
            
    }

}
