<?php

namespace App\Http\Controllers;

use App\Models\Cbody;
use App\Models\Cbrand;
use App\Models\City;
use App\Models\Cmodel;
use App\Models\Color;
use App\Models\Gearbox;
use App\Models\Image;
use App\Models\MarkPost;
use App\Models\Post;
use App\Models\RentOffer;
use App\Models\State;
use App\Models\Type;
use App\Models\UserPanel;
use App\Models\Year;
use App\Models\WebSite;
use App\Models\InstagramId;
use App\Models\PostExtras;
use App\Models\Chat;
use App\Models\Accessory;
use App\Models\MarkLux;
use App\Models\MarkInsurance;
use App\Models\MarkAccessory;
use App\Models\Lux;
use App\Models\Insurance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Morilog\Jalali\Jalalian;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use Pusher\Pusher;


class UserPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      public function  upgrade()
    {
        return view('userpanel.upgrade');
    }
    public function destroy(Request $request)
    {
        $p = Post::all()->where('id', '=', $request->id)->first();
        $p->is_delete = 1;
        $p->is_active = 0;
        $p->own_delete = 1;
        $p->save();
        return response()->json(['success' => true]);
    }

    public function checkCode(Request $request)
    {
    
        $code = $request->input('code');
        $phone = $request->input('phone_number');

        $user = UserPanel::where('phone_num', $phone)->where('regCode', $code)->first();
        // $user = UserPanel::where('phone_num', $phone)->where('regCode', '1234')->first();

        if ($user) {

            ///////// khabar az to /////////////////
            // $off = Rentoffer::all()->where('phone_number' , '=' , $phone)->first();
            // if(!isset($off)){

            //     $noff = new Rentoffer;
            //     $noff->phone_number = $phone;
            //     $noff->save();
            // }
            ///////////////////////////////////////


            ////////////// mark check //////////////////

            $d = unserialize(\Illuminate\Support\Facades\Cookie::get('marks'));
            // return response()->json($d);

            $marks = MarkPost::all()->where('user_id', '=', $user->id)->pluck('post_id')->toArray();


            if (is_array($d)) {

                foreach ($d as $m) {
                    if (!in_array($m, $marks)) {
                        $a = new MarkPost();
                        $a->post_id = $m;
                        $a->user_id = $user->id;
                        $a->save();
                    }
                }
            }

            \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::forget('marks'));


            ///////////////////////////



            Session::put('phone_number', $phone);
            Session::put('login', true);
            return response()->json(array('success' => true), 200);
        } else {
            return response()->json(array('success' => false, 'message' => 'کد وارد شده اشتباه است'), 200);
        }

    }

    public function edit(Request $request, $id)
    {
        $phone = $request->session()->get('phone_number', '0');
        $posts = Post::where('id', $id)->where('phone_number', $phone)->where('is_delete', 0)->first();

        if (!$posts) {
            return redirect('/userpanel/myadvertises')->with('message', 'آگهی مورد نظر موجود نیست');
        }
        // return $posts->get_website();

        $images = Image::where('post_id', $id)->get();
        // return $images;
        $cmodels = Cmodel::where('cbrand_id' , $posts->cbrand_id)->get();
        $cbrands = Cbrand::all()->sortBy('name');
        $states = State::all();
        $cities = City::where('state_id' , $posts->state_id)->get();
        $gearboxes = Gearbox::all();
        $colors = Color::all()->sortBy('name');
        $years = Year::all()->sortByDesc('name');
        $cbodies = Cbody::all()->sortBy('name');
        $types = Type::all()->take(9);

        $data = array(
            'posts' => $posts,
            'images' => $images,
            'image_size' => sizeof($images),
            'cmodels' => $cmodels,
            'cbrands' => $cbrands,
            'states' => $states,
            'cities' => $cities,
            'gearboxes' => $gearboxes,
            'colors' => $colors,
            'years' => $years,
            'cbodies' => $cbodies,
            'types' => $types
        );

        return view('advertises.edit', $data);
    }


    public function my_advertise()
    {
        // dump(url('/'));
        // \Artisan::call('config:clear');
        // \Artisan::call('config:cache');
        // // return config('app.url');
        // return public_path();
        
//         ini_set('max_execution_time', 400);
// // // //        SitemapGenerator::create('http://127.0.0.1:8000')->writeToFile(public_path('sitemap.xml'));
//         SitemapGenerator::create('https://18charkh.com/')->writeToFile('/public_html/sitemap.xml');

//         return "ok";


        $phone_number = session()->get('phone_number', '0');
        $posts = Post::all()
            ->where('phone_number', '=', $phone_number)->where('own_delete' , '=' , 0)->sortByDesc('created_at');


        return view('userpanel.myadvertises', compact('posts', 'phone_number'));
    }

    public function mark_advertise()
    {
        $phone_number = session()->get('phone_number', '0');
        $login = \session()->get('login');
        $user_id = 0;

        if ($login) {
            $user = UserPanel::all()->where('phone_num', '=', $phone_number)->first();
            if (isset($user))
                $user_id = $user->id;
                
            $favorites = DB::table('posts')
                ->join('mark_posts as mp', 'posts.id', '=', 'mp.post_id')
                ->where('mp.user_id', '=', $user_id)
                ->select('posts.created_at' , 'posts.subject' , 'posts.price' , 'posts.image_path' , 'posts.id as id' , 'posts.description' , 'mp.id as mid')->get();

        $accessories = DB::table('accessories as posts')
            ->join('mark_accessories as mp', 'posts.id', '=', 'mp.post_id')
            ->where('mp.user_id', '=', $user_id)
            ->select('posts.created_at' , 'posts.subject' , 'posts.main_img as image_path' , 'posts.id as id' , 'posts.description' , 'mp.id as mid')->get();
            
        $insurances = DB::table('insurances as posts')
            ->join('mark_insurances as mp', 'posts.id', '=', 'mp.post_id')
            ->where('mp.user_id', '=', $user_id)
            ->select('posts.created_at' , 'posts.subject' , 'posts.main_img as image_path' , 'posts.id as id' , 'posts.description' , 'mp.id as mid')->get();            

        $luxes = DB::table('luxes as posts')
            ->join('mark_luxes as mp', 'posts.id', '=', 'mp.post_id')
            ->where('mp.user_id', '=', $user_id)
            ->select('posts.created_at' , 'posts.subject' , 'posts.main_img as image_path' , 'posts.id as id' , 'posts.description' , 'mp.id as mid')->get();            
            

        foreach($luxes as $ac)
            {
                $ac->type = '1';
            }
        foreach($insurances as $ac)
            {
                $ac->type = '2';
            }
        foreach($accessories as $ac)
            {
                $ac->type = '3';
            }
        
        $all = array_merge($accessories->toArray() , $insurances->toArray() , $luxes->toArray() , $favorites->toArray());
        
        $favorites = collect($all)->sortByDesc('created_at');                
                
        }
        else {
            $d = unserialize(Cookie::get('marks'));
            $favorites = Post::all()->whereIn('id' , $d);
        }
        
        return view('userpanel.markadvertises', compact('favorites', 'phone_number'));
    }

    public function offer()
    {
        $states = State::all();
        $types = Type::all()->take(9);
        $phone = session()->get('phone_number', '0');
        
        // return $phone;


        $tenant = RentOffer::all()->where('phone_number', '=', $phone)->first();
        if (!isset($tenant) && $phone != 0) {

            $tenant = new Rentoffer;
            $tenant->phone_number = $phone;
            $tenant->save();
        }


        if (empty($tenant["state_id"]) &&
            empty($tenant["city_id"]) &&
            empty($tenant["type"]) &&
            empty($tenant["driver_status"])){
            $offers = [];
            $null_offer = 0;
        }

        else {
            $offers = Post::where([['is_active', '=', "1"], ['is_delete', '=', '0'], ['is_rent', '=', "1"]]);


            if (isset($tenant["state_id"]))
                $offers = $offers->where('state_id', $tenant["state_id"]);
            if (isset($tenant["city_id"]))
                $offers = $offers->where('city_id', $tenant["city_id"]);
            if (isset($tenant["type"]))
                $offers = $offers->where('type', $tenant["type"]);
            if (isset($tenant["driver_status"])) {
                if ($tenant["driver_status"] == 0) {
                    $offers = $offers->whereIn('driver_status', ['0', '1', '2']);
                } else {
                    $offers = $offers->where('driver_status', $tenant["driver_status"]);
                }
            }


            $offers = $offers->get();
            $null_offer = 1;

        }


        $phone_number = $phone;
        // $tenant = RentOffer::all()->where('phone_number', '=', $phone)->first();

        return view('userpanel.offer', compact('offers', 'phone_number', 'states', 'types', 'tenant' , 'null_offer'));
    }

    public function store_tenant(Request $request)
    {

        $phone = $request->session()->get('phone_number', '0');
        $tenant = RentOffer::all()->where('phone_number', '=', $phone)->first();

        if (!$tenant) {
            $tenant = new RentOffer();
        }
        if (isset($request->d_status))
            $tenant->driver_status = $request->d_status;
        if (isset($request->state_id))
            $tenant->state_id = $request->state_id;
        if (isset($request->city_id))
            $tenant->city_id = $request->city_id;
        if (isset($request->type))
            $tenant->type = $request->type;
        $tenant->save();

        return back();
    }

    public function ajax_tenant(Request $request)
    {
        $phone = session()->get('phone_number', '0');


        $rent_offer = RentOffer::all()->where('phone_number' , '=' , $phone)->first();
//        if ($request->state == null)
//            $rent_offer->city_id = null;
//        else
        $rent_offer->city_id = $request->city;
        $rent_offer->state_id = $request->state;
        $rent_offer->type = $request->type;
        $rent_offer->driver_status = $request->driver;
        $rent_offer->save();

        //////////////// search


        if ($rent_offer->city_id == null &&
            $rent_offer->state_id == null &&
            $rent_offer->type == null &&
            $rent_offer->driver_status == null){
            $null_offer = 0;
            return response()->json(['data' => [] , 'null_offer' => $null_offer]);
        }
        else{

            $rents = Post::where([['is_active', '=' , "1"] , ['is_delete' , '=' , '0'] , ['is_rent' , '=' , "1"]]);

            if (isset($rent_offer["state_id"]))
                $rents = $rents->where('state_id', $rent_offer["state_id"]);
            if (isset($rent_offer["city_id"]))
                $rents = $rents->where('city_id', $rent_offer["city_id"]);
            if (isset($rent_offer["type"]))
                $rents = $rents->where('type', $rent_offer["type"]);
            if (isset($rent_offer["driver_status"])) {
                if ($rent_offer["driver_status"] == 0) {
                    $rents = $rents->whereIn('driver_status', ['0', '1', '2']);
                } else {
                    $rents = $rents->where('driver_status', $rent_offer["driver_status"]);
                }
            }

            $null_offer = 1;
            return response()->json(['data' => $rents->get() , 'null_offer' => $null_offer]);

        }


    }

    public function logout()
    {
        // return "sdfasdfasdfas";
        Session::forget('phone_number');
        Session::forget('login');
        // dd(Session::forget('login'));
        return redirect('/userpanel/myadvertises');
    }
    
     public function message()
    {
        
        $phone_number = session()->get('phone_number', '0');
        $user_id = "";

        if ($phone_number != 0) {
            $user = UserPanel::where('phone_num', '=', $phone_number)->first();
            if (!$user){
                $user_id = 0;
            }else{
                $user_id = $user->id;
                Session::put('user_send_message_id', $user_id);
            }
                
        }
        $bind = ['id' => $user_id];
        $chats = DB::select("
        select *
        from chats
        where user_id = :id
        " , $bind);
        

        return view('userpanel.message' , compact('phone_number' , 'chats'));
    }
    
     public function send_message(Request $request)
    {
        $user_id = session()->get('user_send_message_id', '0');
        
        $chat = new Chat();
        $chat->user_id = $user_id;
        $chat->reply = 0;
        $chat->content = $request->message;
        $chat->save();
        
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

        $time = \Morilog\Jalali\Jalalian::now()->addHours(3)->addMinutes(30)->format('H:i - %B %d');
        $mobile = session()->get('phone_number', '0');
        $data = ['userId' => $user_id , 'from_user' => 1 , 'content' => $request->message , 'time' => $time , 'mobile' => $mobile];
        $pusher->trigger('message_channel' , 'message_event' , $data);
        
        
        
        
        return response(['success' => true , 'time' => $time]);
    }
    

        public function update(Request $request)
    {
        
        
        
        $this->validate(
            $request,
            ['description' => 'required',
                'subject' => 'required',
                'phone_number' => 'required',],

            ['description.required' => 'موضوع آگهی الزامی می باشد.',
                'subject.required' => 'عنوان آگهی الزامی می باشد.',
                'phone_number.required' => 'شماره تلفن الزامی می باشد.']
        );
            
        // return $request;
        
        // Update Posts

        $posts_ad = Post::find($request->id);
        
        // if($request->instagram_id != $posts_ad->instagram_id)
        // if(isset($posts_ad->instagram_id))
        //     $posts_ad->instagram_id = $request->instagram_id;
        // return "nist";

        $posts_ad->cbrand_id = $request->cbrand_id;
        $posts_ad->image_path = $request['img_base64_one'];
        $posts_ad->cmodel_id = $request->cmodel_id;
        $posts_ad->year_id = $request->year_id;
        $posts_ad->gearbox_id = $request->gearbox_id;
        $posts_ad->distance = $request->distance;
        $posts_ad->color_id = $request->color_id;
        $posts_ad->cbody_id = $request->cbody_id;
        $posts_ad->price = $request->price;
        $posts_ad->subject = $request->subject;
        // $posts_ad->phone_number = $request->phone_number;
        $posts_ad->email = $request->email;
        $posts_ad->description = $request->description;
        $posts_ad->state_id = $request->state_id;
        $posts_ad->city_id = $request->city_id;
        
        $cart = collect();

        if(isset($request->instagram_id)){
            if(isset($posts_ad->instagram_id)){ // pardakht anjam shode va faghat taghir mikonad
                $posts_ad->instagram_id = $request->instagram_id;
            }else if($posts_ad->get_instagram() == ""){ // ta alaan insta_id sabt nakarde bood
            $cart->push("instagram");
            $insta = new InstagramId;
            $insta->post_id = $posts_ad->id;
            $insta->instagram_id = $request->instagram_id;
            $insta->save();
            }else{
            $insta = InstagramId::where('post_id' , '=' , $posts_ad->id)->first();
            $insta->instagram_id = $request->instagram_id;
            $insta->save();
            }
        }
        
        if(isset($request->website)){
            if(isset($posts_ad->website)){ // pardakht anjam shode va faghat taghir mikonad
                $posts_ad->website = $request->website;
            }else if($posts_ad->get_website() == ""){ // ta alaan website sabt nakarde bood
            $cart->push("website");
            $web = new WebSite;
            $web->post_id = $posts_ad->id;
            $web->website = $request->website;
            $web->save();
            }else{
            $web = WebSite::where('post_id' , '=' , $posts_ad->id)->first();
            $web->website = $request->website;
            $web->save();
            }
        }

        $posts_ad->type = $request->type;
        if (isset($request->meta)) {
            $posts_ad->meta = $request->meta;
        }
        if (isset($request->trending)) {
            $posts_ad->trending = true;
        } else {
            $posts_ad->trending = false;
        }
        
        $posts_ad->is_active = 0;
        $posts_ad->is_pending = 1;
        $posts_ad->save();
        
        // $images = Image::all()->where('post_id', '=', $request->id);
        // foreach ($images as $img){
        //     $img->delete();
        // }
        
        $images = Image::where('post_id', '=', $request->id)->get();
        
        $a_images = $images->pluck('path')->toArray();

        
        if (isset($request['img_base64_one']) && $request['img_base64_one'] != "noimage.jpg" && $request['img_base64_one'] != $images[0]->path){

        // if ($request['img_base64_one'] != "" && $request['img_base64_one'] != "noimage.jpg"){
            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_one']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(300, 300);
            $img->insert($watermark, 'bottom-left', 5, 5);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_one']);


            if(isset($images[0])){
                $images[0]->path = $request['img_base64_one'];
                $images[0]->save();
            }
            else{
                $image = new Image;
                $image->post_id = $posts_ad->id;
                $image->path = $request['img_base64_one'];
                $image->save();
            }


            // $image = new Image;
            // $image->post_id = $posts_ad->id;
            // $image->path = $request['img_base64_one'];
            // $image->save();

        }
        // else{
        //     $image = new Image;
        //     $image->post_id = $posts_ad->id;
        //     $image->path = "noimage.jpg";
        //     $image->save();
        // }

        // if ($request['img_base64_two'] != "") {
        if ($request['img_base64_two'] != "" && !in_array($request['img_base64_two'] , $a_images)){

            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_two']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(300, 300);
            $img->insert($watermark, 'bottom-left', 5, 5);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_two']);

            if(isset($images[1])){
                $images[1]->path = $request['img_base64_two'];
                $images[1]->save();
            }
            else{
                $image = new Image;
                $image->post_id = $posts_ad->id;
                $image->path = $request['img_base64_two'];
                $image->save();
            }

            // $image = new Image;
            // $image->post_id = $posts_ad->id;
            // $image->path = $request['img_base64_two'];
            // $image->save();
        }

        // if ($request['img_base64_three'] != ""){
        if ($request['img_base64_three'] != "" && !in_array($request['img_base64_three'] , $a_images)){

            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_three']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(300, 300);
            $img->insert($watermark, 'bottom-left', 5, 5);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_three']);

            if(isset($images[2])){
                $images[2]->path = $request['img_base64_three'];
                $images[2]->save();
            }
            else{
                $image = new Image;
                $image->post_id = $posts_ad->id;
                $image->path = $request['img_base64_three'];
                $image->save();
            }

            // $image = new Image;
            // $image->post_id = $posts_ad->id;
            // $image->path = $request['img_base64_three'];
            // $image->save();
            
        }

        // if ($request['img_base64_four'] != ""){
        if ($request['img_base64_four'] != "" && !in_array($request['img_base64_four'] , $a_images)){

            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_four']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(300, 300);
            $img->insert($watermark, 'bottom-left', 5, 5);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_four']);

            if(isset($images[3])){
                $images[3]->path = $request['img_base64_four'];
                $images[3]->save();
            }
            else{
                $image = new Image;
                $image->post_id = $posts_ad->id;
                $image->path = $request['img_base64_four'];
                $image->save();
            }

            // $image = new Image;
            // $image->post_id = $posts_ad->id;
            // $image->path = $request['img_base64_four'];
            // $image->save();

        }
        
        
            if (count($cart) > 0){
            
            $bind = [
                'mobile' => $request->phone_number
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
            
            return redirect('/userpanel/financial/post/' . $posts_ad->id . '/cart');
            
        }
        
        return redirect('/userpanel/myadvertises')->with('success', 'آگهی شما با موفقیت ویرایش گردید');

    }

    public function lateral(){
        
        $phone_number = session()->get('phone_number', '0');
        
        $accessories = Accessory::where('phone_number' , $phone_number)->get();
        
        foreach($accessories as $ac)
        {
            $ac['type'] = 'accessory';
        }
        
        $insurances = Insurance::where('phone_number' , $phone_number)->get();
        
        foreach($insurances as $ac)
        {
            $ac['type'] = 'insurance';
        }
        
        $luxes = Lux::where('phone_number' , $phone_number)->get();
        
        foreach($luxes as $ac)
        {
            $ac['type'] = 'lux';
        }

        $all = array_merge($accessories->toArray() , $insurances->toArray() , $luxes->toArray());
        

        $data = [
            'phone_number' => $phone_number,
            'all' => collect($all)->sortByDesc('created_at')
            ];
        
    
        
        return view('userpanel.lateral' , $data);
    }


}
