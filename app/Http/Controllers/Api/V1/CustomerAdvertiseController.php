<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Accessory;
use App\Models\Insurance;
use App\Models\Lux;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CustomerAdvertiseController extends Controller
{
    public $loginAfterSignUp = true;

    public function __construct()
    {
        auth()->setDefaultDriver('api');
    }
    
    public function all(Request $request){

        $luxes = Lux::where('is_active' , 1);
        $ins = Insurance::where('is_active' , 1);
        $acc = Accessory::where('is_active' , 1);
        
        if (isset($request->term)){
            $luxes = $luxes->where('name', 'LIKE', '%' . $request->term . '%')
                ->orWhere('address', 'LIKE', '%' . $request->term . '%');
            $ins = $ins->where('name', 'LIKE', '%' . $request->term . '%')
                ->orWhere('address', 'LIKE', '%' . $request->term . '%');
            $acc = $acc->where('name', 'LIKE', '%' . $request->term . '%')
                ->orWhere('address', 'LIKE', '%' . $request->term . '%');
        }

        if (isset($request->state)){
            $luxes = $luxes->where('state_id', '=', $request->state);
            $acc = $acc->where('state_id', '=', $request->state);
            $ins = $ins->where('state_id', '=', $request->state);
        }

        if (isset($request->city)){
            $luxes = $luxes->where('city_id', '=', $request->city);
            $ins = $ins->where('city_id', '=', $request->city);
            $acc = $acc->where('city_id', '=', $request->city);
        }

        $p = [];
        array_push($p , array('list' => array('item' => 1 , 'list' => $luxes->get())));
        array_push($p , array('list' => array('item' => 2 , 'list' => $ins->get())));
        array_push($p , array('list' => array('item' => 3 , 'list' => $acc->get())));
        
        return response()->json(['success' => true, 'data' => $p ]);    

        
    }

    private function services($service , $request){


        if (isset($request->term)){
            $service = $service->where('name', 'LIKE', '%' . $request->term . '%')
                ->orWhere('address', 'LIKE', '%' . $request->term . '%');
        }

        if (isset($request->state)){
            $service = $service->where('state_id', '=', $request->state);
        }

        if (isset($request->city)){
            $service = $service->where('city_id', '=', $request->city);
        }
        
    
        return $service->where('is_active' , 1)->orderBy('created_at', 'desc')->get();
        
        return response()->json(['success' => true, 'data' => $this->services($serv , $request) ]);    


    }

    private function store($model, $request)
    {
        $item = $model::create($request->all());

        $item->tels()->createMany($request['tel']);

        if (isset($request->images)) {
            $item->main_img = $request->images[0]['image_name'];

            foreach ($request->images as $image) {

                $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $image['image_name']);

                $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
                $img->resize(600, 600);
                $img->insert($watermark, 'bottom-left', 10, 10);

                $img->resize(600, 600);

                $success = $img->save('post_images/related_images_watermark/' . $image['image_name']);

                $item->images()->create(['path' => $image['image_name']]);

            }
        } else {
            $item->main_img = "noimage.jpg";
        }
            $item->save();

        return true;


    }


    private function update($model , $request , $id)
    {
        return true;
    }

    private function getItem($model, $id)
    {
        $item = $model::where('id' , $id)->where('is_active' , 1)->first();
        
        if(empty($item))
            return null;
        
        $item['tels'] = $item->tels;
        $item['images'] = $item->images;

        return $item;
    }

    public function lux(Request $request){

        $serv = Lux::query();
        
        return response()->json(['success' => true, 'data' => $this->services($serv , $request) ]);    
        
    }

    public function insurance(Request $request){

        $serv = Insurance::query();

        return response()->json(['success' => true, 'data' => $this->services($serv , $request) ]);
    }

    public function accessory(Request $request){

        $serv = Accessory::query();

        return response()->json(['success' => true, 'data' => $this->services($serv , $request) ]);
    }

    public function lux_store(Request $request)
    {
        $model = Lux::class;
        return response()->json(['success' => $this->store($model, $request)]);
    }

    public function accessory_store(Request $request)
    {
        $model = Accessory::class;
        return response()->json(['success' => $this->store($model, $request)]);

    }

    public function insurance_store(Request $request)
    {
        $model = Insurance::class;
        return response()->json(['success' => $this->store($model, $request)]);


    }

    public function lux_show($id)
    {
        return response()->json(['item' => $this->getItem(Lux::class , $id) , 'success' => true]);
    }

    public function accessory_show($id)
    {
        return response()->json(['item' => $this->getItem(Accessory::class , $id) , 'success' => true]);
    }

    public function insurance_show($id)
    {
        return response()->json(['item' => $this->getItem(Insurance::class , $id) , 'success' => true]);
    }
    
    public function my_ads(Request $request){
        
        $user_token = $request->header('Authorization');
        $user = JWTAuth::toUser($user_token);
        
    
        $accessories = Accessory::where('phone_number' , $user->phone_num)->get();
        
        foreach($accessories as $ac)
        {
            $ac['type'] = 'accessory';
        }
        
        $insurances = Insurance::where('phone_number' , $user->phone_num)->get();
        
        foreach($insurances as $ac)
        {
            $ac['type'] = 'insurance';
        }
        
        $luxes = Lux::where('phone_number' , $user->phone_num)->get();
        
        foreach($luxes as $ac)
        {
            $ac['type'] = 'lux';
        }

        $all = array_merge($accessories->toArray() , $insurances->toArray() , $luxes->toArray());
        
        
        return response()->json(['ads' => $all , 'success' => true]);
        
    }

}
