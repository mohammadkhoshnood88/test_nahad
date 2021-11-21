<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use App\Models\UserPanel;
use Illuminate\Support\Facades\DB;


class BaseAdvertiseController extends Controller
{
    protected $model;
    protected $table;
    protected $visit;
    protected $mark;

    public function getAll($term = null , $ajax = false) :array
    {
        $data = $this->model::query()->where('is_active' , '=' , '1');

        if (isset($term)){
            $data = $data->where('subject', 'LIKE', '%' . $term . '%')
                ->orWhere('description', 'LIKE', '%' . $term . '%')
                ->orWhere('address', 'LIKE', '%' . $term . '%');
        }

        $count = $data->where('is_active' , '=' , 1)->count();

        $all = $data->orderBy('created_at' , 'desc')->paginate(20);

        if ($ajax) {
            return response()->json(['data' => $all]);
        }
        $states = State::all();

        $collect = array(
            'data' => $all,
            'term' => $term,
            'count' => $count,
            'states' => $states
        );

        return $collect;
    }

    public function getItem($id) :array
    {   
        $phone = session()->get('phone_number');
        $mark = null;
        if (isset($phone)){
            
            $user_id = Userpanel::where('phone_num' , $phone)->first()->id;
            $mark = $this->mark::where('user_id' , $user_id)->first();
            
        }

        $this->addVisit($id);
        return array(
                $this->model::where('id' , $id)->where('is_active' , 1)->first() ,
                $mark
            );
    }

    public function verification($request)
    {
        $i = $this->validate($request,
            [
                'description' => 'required',
                'subject' => 'required',
                'state_id' => 'required',
                'city_id' => 'required',
                'phone_number' => 'required|digits:11',
            ]
            ,
            [
                'description.required' => 'موضوع آگهی الزامی می باشد',
                'subject.required' => 'عنوان آگهی الزامی می باشد',
                'state_id.required' => 'استان را به درستی انتخاب کنید',
                'city_id.required' => 'شهر را به درستی انتخاب کنید',
                'phone_number.required' => 'شماره تلفن الزامی می باشد',
                'phone_number.numeric' => 'شماره تلفن صحیح نمیباشد',
                'phone_number.digits' => 'شماره تلفن صحیح نمیباشد',
            ]
        );


        $phone = strtr($request->phone_number, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
        $req['phone_number'] = $phone;

        $req = $request->toArray();
        
        
        \session()->put('key', 'valid');
        \session()->put('phone', $phone);
        \session()->put('request', $req);

        $rand = rand(1000, 9999);

        $user = UserPanel::where('phone_num', $phone)->first();

        if ($user) {
            $user->regCode = $rand;
            $user->save();
        } else {
            $nuser = new UserPanel();
            $nuser->regCode = $rand;
            $nuser->phone_num = $phone;
            $nuser->save();
        }

        return sms($phone , $rand);

    }

    public function addItem($request)
    {
        $item = $this->model::create($request);

        if (isset($request['images'][0]))
        {
            $item->main_img = $request['images'][0];

            foreach ($request['images'] as $image) {
                if($image != null){
                    
                $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $image);

                $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
                $img->fit(300, 300);
                $img->orientate();
                $img->insert($watermark, 'bottom-left', 5, 5);

                $success = $img->save('post_images/related_images_watermark/' . $image);

                $item->images()->create(['path' => $image]);
                    
                }

            }

        }
        else 
        {
            $item->main_img = 'noimage.jpg';
            $item->images()->create(['path' => 'noimage.jpg']);
        }
        $item->save();
        if (!isset($request['hide_phone_number'])){
            $item->tels()->create(['tel' => $request['phone_number']]);
        }
        
        return $item->id;

    }
    
    public function update(Request $request , $id)
    {
        $item = $this->model::find($id);
        $item->update($request->all());
        $item->main_img = $request['images'][0];
        $item->save();
            if ($request['images'][0] != 'noimage.jpg')
            {
                $item->images()->delete();
                
                foreach ($request['images'] as $image) {
                if($image != null){

                        $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $image);

                        $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
                        $img->fit(300, 300);
                        $img->orientate();
                        $img->insert($watermark, 'bottom-left', 5, 5);

                        $success = $img->save('post_images/related_images_watermark/' . $image);

                        $item->images()->create(['path' => $image]);
                        
                }

            }
            }

        
        
        if (isset($request['hide_phone_number']) && $request['hide_phone_number'] == "on"){
            $item->tels()->where('tel' , $request['phone_number'])->delete();
        }
        
        return redirect('/userpanel/lateral');

    }
    
    public function destroy(Request $request)
    {
        $item = $this->model::find($request->id);
        $item->delete();
        $item->images()->delete();
        $item->tels()->delete();
        
        return response()->json(['success' => true]);
        
    }
    
    private function addVisit($id)
    {
        $bind = [
            'id' => $id
        ];
        
        $visits = DB::select("
        select ip
        from visits
        where post_id = :id
        " , $bind);
        
        $visits = $this->visit::where('post_id' , $id)->get();

        $ip = \request()->ip();

        $i = 0;
        $flag = 0;
        
        while ($i < count($visits) && $flag == 0)
        {
            if ($visits[$i]->ip == $ip){
                $flag = 1;
            }
            $i++;
        }
        
        if ($flag == 0)
        {
            $visit = $this->visit::create(['ip' => $ip , 'post_id' => $id]);
        }
        
    }
    
    
    public function mark(Request $request)
    {
        $phone = session()->get('phone_number', '0');

        if (!$phone) {
            return response()->json(["auth" => false]);
        }

        $user = UserPanel::where('phone_num', $phone)->first();
        $user_id = $user->id;
        $mark = $this->mark::where('post_id', $request->post_id)->where('user_id', '=', $user_id)->first();

        if (empty($mark)) {
            $this->mark::create(['post_id' => $request->post_id , 'user_id' => $user_id]);
            return response()->json(['auth' => true , 'mark' => true]);

        } else {
            $mark->delete();
            return response()->json(['auth' => true , 'mark' => false]);
        }

        return response()->json("another");
    }

}
