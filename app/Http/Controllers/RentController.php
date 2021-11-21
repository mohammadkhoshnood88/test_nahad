<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Post;
use App\Models\RentImage;
use App\Models\Image;
use App\Models\State;
use App\Models\Type;
use App\Models\UserPanel;
use App\Models\VehicleMeta;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\InstagramId;
use App\Models\Year;
use App\Models\WebSite;
use App\Models\Visit;
use App\Models\PostExtras;
use Carbon\Carbon;
use Pusher\Pusher;


class RentController extends Controller
{

    public function index(Request $request)
    {
        $rents = Post::query()->where('is_active' , '=' , '1')->where('is_rent' , '=' , 1);
        
        if (isset($request->term)){
            $rents = $rents->where('subject', 'LIKE', '%' . $request->term . '%')
            ->orWhere('description', 'LIKE', '%' . $request->term . '%');
        }
        
        $count = $rents->where('is_rent' , '=' , 1)->count();
        
        $all_posts = $rents->where('is_rent' , '=' , 1)->orderBy('sort_id' , 'desc')->paginate(20);
        
        if ($request->ajax()) {
            return response()->json(['data' => $all_posts]);
        }
        
        $vip = DB::select("
        SELECT posts.id, posts.subject, posts.price , posts.description , posts.image_path , posts.trending
        FROM posts
        INNER JOIN vip_posts ON posts.id = vip_posts.post_id
        where posts.is_active = 1 and posts.is_rent = 1
        ");
        
        $term = (isset($request->term) ? $request->term : "");

        $states = DB::select("
            select *
            from states");
        

        $types = Type::all()->take(9);

        return view('rent.rent',
            compact('all_posts', 'states', 'types' , 'term' , 'count' , 'vip'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        Session::forget('key');

        $states = State::all();
        $cities = City::all();
        $types = Type::all()->take(9);
        return view('rent.create', compact('states', 'types', 'cities'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        return $request;

        if (\session()->get('key') == 'valid')
        {
            Session::forget('key');
            return redirect('/rent/create');
        }

        $this->validate(
            $request,
            [
                'subject' => 'required',
                'description' => 'required',
                'phone_number' => 'required',
                'type' => 'required',
//                'cbrand_id' => 'required',
                'state_id' => 'required',
                'city_id' => 'required',
                'img-upload-one' => 'file|image|mimes:jpeg,jpg,png',
                'img-upload-two' => 'file|image|mimes:jpeg,jpg,png',
                'img-upload-three' => 'file|image|mimes:jpeg,jpg,png',
                'img-upload-four' => 'file|image|mimes:jpeg,jpg,png'
            ],

            [
                'subject.required' => 'عنوان آگهی الزامی می باشد',
//                'cbrand_id.required' => 'عنوان آگهی الزامی می باشد',
                'description.required' => 'توضیحات آگهی الزامی است',
                'phone_number.required' => 'شماره تلفن را به درستی وارد کنید',
                'state_id.required' => 'استان را به درستی انتخاب کنید',
                'city_id.required' => 'شهر را به درستی انتخاب کنید',
                'type.required' => 'نوع ماشین الزامی می باشد',
                'image' => 'نوع فایل انتخابی صحیح نیست',
                'mimes' => 'نوع فایل انتخابی صحیح نیست',
            ]
        );


        $images = array();
        $req = $request->toArray();


        // Handle File Upload

        /*if ($request->hasFile('img-upload-one')) {

            $file = $request->file('img-upload-one');
            $filename1 = time() . $file->getClientOriginalName();
            $file->move('post_images/related_images', $filename1);

        } else {
            $filename1 = 'noimage.jpg';
        }
        $req['img-upload-one'] = null;


        if ($request->hasFile('img-upload-two')) {

            $file = $request->file('img-upload-two');
            $filename2 = time() . $file->getClientOriginalName();
            $file->move('post_images/related_images', $filename2);
            $req['img-upload-two'] = null;

        }else
            $filename2 = "";


        if ($request->hasFile('img-upload-three')) {

            $file = $request->file('img-upload-three');
            $filename3 = time() . $file->getClientOriginalName();
            $file->move('post_images/related_images', $filename3);
            $req['img-upload-three'] = null;
        }else
            $filename3 = "";

        if ($request->hasFile('img-upload-four')) {

            $file = $request->file('img-upload-four');
            $filename4 = time() . $file->getClientOriginalName();
            $file->move('post_images/related_images', $filename4);
            $req['img-upload-four'] = null;
        }else
            $filename4 = "";

        array_push($images , $filename1 , $filename2 , $filename3 , $filename4);*/

        \session()->put('key' , 'valid');
        \session()->put('phone' , $request->phone_number);
        \session()->put('request' , $req);

        $rand = rand(1000, 9999);
        $phone = $request['phone_number'];


        $user = UserPanel::where('phone_num', $phone)->first();
        if ($user) {
            $user->regCode = $rand;
            // $user->regCode = '1234';
            $user->save();
        } else {
            $nuser = new UserPanel();
            $nuser->regCode = $rand;
            // $nuser->regCode = '1234';
            $nuser->phone_num = $phone;
            $nuser->save();
        }
        
        sms($phone, $rand);


        return view('advertises/checkcode');

    }


    public function verify_rent()
    {
        $url = explode('/', url()->previous());


        if (\session()->get('key') != 'valid' || end($url) != 'store') {
            Session::forget('key');
            abort('403', "کجا میای داداش؟");
        }


        $request = \session()->get('request');
        $images = \session()->get('images');


        $posts_ad = new Post();
        $posts_ad->type = $request['type'];
        $posts_ad->phone_number = $request['phone_number'];

        if (isset($request['img_base64_one']))
            $posts_ad->image_path = $request['img_base64_one'];
        else
            $posts_ad->image_path = "noimage.jpg";
        
        $posts_ad->email = $request['email'];
        $posts_ad->is_rent = 1;
        $posts_ad->state_id = $request['state_id'];
        $posts_ad->city_id = $request['city_id'];
        if (array_key_exists('workers' , $request))
            $workers = strtr($request['workers'], array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
        else
            $workers = "";
        $posts_ad->workers = $workers;
        $posts_ad->subject = $request['subject'];
        $posts_ad->description = $request['description'];
        $posts_ad->location = $request['location'];
        $posts_ad->driver_status = $request['driver_status'];
        $posts_ad->sort_id = Carbon::now();
        $posts_ad->save();
        
        $cart = collect();

        
        if (isset($request['instagram_id'])) {
            $cart->push("instagram");
            $insta = new InstagramId;
            $insta->post_id = $posts_ad->id;
            $insta->instagram_id = $request['instagram_id'];
            $insta->save();
        }

        if (isset($request['website'])) {
            $cart->push("website");
            $web = new WebSite();
            $web->post_id = $posts_ad->id;
            $web->website = $request['website'];
            $web->save();
        }

        if (count($cart) > 0){
            
            $bind = [
                'mobile' => $request['phone_number']
                    ];
            $user_id = DB::select("
                select id
                from user_panels
                where phone_num = :mobile
                " , $bind);
            
            \session()->flash('cart', true);
            
            foreach ($cart as $c){

                $post_extras = new PostExtras();
                $post_extras->user_id = $user_id[0]->id;
                $post_extras->post_id = $posts_ad->id;
                $post_extras->option_name = $c;
                $post_extras->option_id = 1;
                $post_extras->payment = 0;
                $post_extras->save();

            }
        }

        $images = array();
        if (isset($request['img_base64_one'])){
            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_one']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(600, 600);
            $img->insert($watermark, 'bottom-left', 10, 10);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_one']);

            $image = new Image;
            $image->post_id = $posts_ad->id;
            $image->path = $request['img_base64_one'];
            $image->save();
            array_push($images , $request['img_base64_one']);
//            $images[] = $request['img_base64_one'];
        }else{
            $image = new Image();
            $image->post_id = $posts_ad->id;
            $image->path = "noimage.jpg";
            $image->save();
            array_push($images , "noimage.jpg");
        }

        if (isset($request['img_base64_two'])){
            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_two']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(600, 600);
            $img->insert($watermark, 'bottom-left', 10, 10);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_two']);

            $image = new Image;
            $image->post_id = $posts_ad->id;
            $image->path = $request['img_base64_two'];
            $image->save();
//            $images[] = $request['img_base64_two'];
            array_push($images , $request['img_base64_two']);


        }

        if (isset($request['img_base64_three'])){
            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_three']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(600, 600);
            $img->insert($watermark, 'bottom-left', 10, 10);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_three']);

            $image = new Image;
            $image->post_id = $posts_ad->id;
            $image->path = $request['img_base64_three'];
            $image->save();
//            $images[] = $request['img_base64_three'];
            array_push($images , $request['img_base64_three']);

        }

        if (isset($request['img_base64_four'])){
            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_four']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(600, 600);
            $img->insert($watermark, 'bottom-left', 10, 10);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_four']);

            $image = new Image;
            $image->post_id = $posts_ad->id;
            $image->path = $request['img_base64_four'];
            $image->save();
//            $images[] = $request['img_base64_four'];
            array_push($images , $request['img_base64_four']);

        }


        Session::forget(['key' , 'request']);
        
        /////////////////////// pusher //////////////////////////
        
        $options = array(
            'cluster'=> 'ap2',
            'useTLS' => true
        );
        
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['id' => $posts_ad->id,
                'image' => $posts_ad->image_path ,
                'brand' => "a" ,
                'subject' => $posts_ad->subject ,
                'mobile' => $posts_ad->phone_number,
                'is_rent' => $posts_ad->is_rent];

        $pusher->trigger('new_post_channel' , 'new_post_event' , $data);

        \session()->put('store_post' , 'آگهی شما با موفقیت ثبت شد');
        \session()->put('login', true);
        \session()->put('phone_number' , $request['phone_number']);
        
        return view('advertises.preview' , compact('posts_ad' , 'images'));

        
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('rent.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function rent_type($id , Request $request)
    {
        // $a = Type::all()->where('id' , '=' , $id)->first();
        // $rents = $a->posts();
        $states = State::all();
        $cities = City::all();
        $types = Type::all()->take(9);
        $metas = VehicleMeta::all();
        
        $rents = Post::query()->where('is_active' , '=' , '1')->where('is_rent' , '=' , 1)->where('type' , '=' , $id);

        if (isset($request->term)){
            $rents = $rents->where('subject', 'LIKE', '%' . $request->term . '%')
                ->orWhere('description', 'LIKE', '%' . $request->term . '%');
        }

        $rents= $rents->where('is_rent' , '=' , 1)->where('type' , '=' , $id)->get()->sortByDesc('sort_id');

        if ($request->ajax()) {
            return response()->json(['data' => $rents]);
        }


        $term = (isset($request->term) ? $request->term : "");
        

        $vip = DB::select("
        SELECT posts.id, posts.subject, posts.price , posts.description , posts.image_path , posts.trending
        FROM posts
        INNER JOIN vip_posts ON posts.id = vip_posts.post_id
        where posts.is_active = 1 and posts.is_rent = 1
        ");


                $count = count($rents);
                $all_posts = $rents;

        return view('rent.rent',
            compact('all_posts', 'cities', 'states', 'types', 'metas' , 'term' , 'vip' , 'count'));

    }

}
