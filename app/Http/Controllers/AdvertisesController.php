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
use App\Models\State;
use App\Models\Type;
use App\Models\UserPanel;
use App\Models\InstagramId;
use App\Models\Year;
use App\Models\WebSite;
use App\Models\Visit;
use App\Models\PostExtras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
// use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Pusher\Pusher;


class AdvertisesController extends Controller
{

    public function index(Request $request)
    {
        $posts = Post::query();
        
        if (isset($request->term)){
            $posts = $posts->where('subject', 'LIKE', '%' . $request->term . '%')
                ->orWhere('description', 'LIKE', '%' . $request->term . '%');
        }
        $count_posts = $posts->where('is_rent' , '=' , 0)->where('is_active' , '=' , '1')->count();

        $all_posts = $posts->where('is_rent' , '=' , 0)->where('is_active' , '=' , '1')->orderBy('sort_id' , 'desc')->paginate(20);
        
        if ($request->ajax()) {
            return response()->json(['data' => $all_posts]);
        }
        
        $now = Carbon::now()->addHours(3)->addMinutes(30)->subDays(2);
        // timezone taghir nakard az haminja taghir dadam
        $bind = ['nt' => $now];
        
        $vip_posts = DB::select("
        SELECT posts.id, posts.subject, posts.price , posts.description , posts.image_path , posts.trending , vip_posts.created_at
        FROM posts
        INNER JOIN vip_posts ON posts.id = vip_posts.post_id
        where posts.is_active = 1 and posts.is_rent = 0 and vip_posts.created_at >= :nt
        ORDER BY posts.sort_id DESC
        " , $bind);
        
        
        $term = (isset($request->term) ? $request->term : "");
        $types = Type::all()->take(9);
        
        
        
        $cmodels = DB::select("
            select *
            from cmodels");
        $cbrands = DB::select("
            select *
            from cbrands as c
            order by (c.name) asc");
        $colors = DB::select("
            select *
            from colors as c
            order by (c.name) asc");
        $years = DB::select("
            select *
            from years as y
            order by (y.name) desc");
        $gearboxes = DB::select("
            select *
            from gearboxes");
        $bodies = DB::select("
            select *
            from cbodies");
        $states = DB::select("
            select *
            from states");
      

        $data = array(
            'cmodels' => $cmodels,
            'term' => $term,
            'cbrands' => $cbrands,
            'colors' => $colors,
            'posts' => $all_posts,
            'vip' => $vip_posts,
            'count' => $count_posts,
            'years' => $years,
            'gearboxes' => $gearboxes,
            'bodies' => $bodies,
            'states' => $states,
            'types' => $types

        );
        
        // $e = Carbon::now();
        // return "total time : " . Carbon::parse($s)->diffInMicroseconds($e);


        return view('advertises.sell' , $data);
    }
    
        public function index_ajax(Request $request)
    {
        $t = $request->term;
        $f = $request->f;
        $a = "%$t%";
        $bind = [
            'f' => $f,
            't' => $f + 20,
            'term' => $a
        ];

        $posts = DB::select("
        select *
        from posts
        where is_active = 1 and is_delete = 0 and is_rent = 0 and subject like :term
        order by id desc
        limit :f , :t
        " , $bind);

        return response()->json(['data' => $posts]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        // return view('errors.update');
        Session::forget('key');
//        $meta = VehicleMeta::all()->where('type_id' , '=' , '1');
//        return response()->json(['meta'=> $meta]);

        // $cmodels = Cmodel::all();
        // $cbrands = Cbrand::all();
        // $states = State::all();
        // $cities = City::all();
        // $gearboxes = Gearbox::all();
        // $colors = Color::all();
        // $years = Year::all();
        // $cbodies = Cbody::all();
        $types = Type::all()->take(9);
        
        $cmodels = DB::select("
            select *
            from cmodels as c
            order by (c.name) asc");
            
        $cbrands = DB::select("
            select *
            from cbrands as c
            order by (c.name) asc");
            
        $colors = DB::select("
            select *
            from colors as c
            order by (c.name) asc");
        // $years = DB::select("
        //     select *
        //     from years");
            
        $years = DB::select("
            select *
            from years as y
            order by (y.name) desc");
            
        $gearboxes = DB::select("
            select *
            from gearboxes");
        $cbodies = DB::select("
            select *
            from cbodies");
        $states = DB::select("
            select *
            from states");
        

        $data = array(
            'cmodels' => $cmodels,
            'cbrands' => $cbrands,
            'states' => $states,
            // 'cities' => $cities,
            'gearboxes' => $gearboxes,
            'colors' => $colors,
            'years' => $years,
            'cbodies' => $cbodies,
            'types' => $types
        );


        return view('advertises.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (\session()->get('key') == 'valid') {
            Session::forget('key');
            return redirect('advertises/create');
        }

        $this->validate($request,
            [
                'description' => 'required',
                'subject' => 'required',
                'state_id' => 'required',
                'city_id' => 'required',
                'type' => 'required',
                'phone_number' => 'required|digits:11',
                'cbrand_id' => 'required',
                'distance' => 'required',
                'img-upload-one' => 'file|image|mimes:jpeg,jpg,png',
                'img-upload-two' => 'file|image|mimes:jpeg,jpg,png',
                'img-upload-three' => 'file|image|mimes:jpeg,jpg,png',
                'img-upload-four' => 'file|image|mimes:jpeg,jpg,png'
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
                'type.required' => 'نوع ماشین را به درستی وارد کنید',
                'cbrand_id.required' => 'برند خودرو را به درستی وارد کنید',
                'distance.required' => 'میزان کارکرد الزامی می باشد',
                'distance.numeric' => 'میزان کارکرد باید به عدد نوشته شود',
                'image' => 'نوع فایل انتخابی صحیح نیست',
                'mimes' => 'نوع فایل انتخابی صحیح نیست',
            ]
        );

        $images = array();
        $req = $request->toArray();
        

        $phone = strtr($request->phone_number, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));        
        $req['phone_number'] = $phone;
        

        \session()->put('key', 'valid');
        // \session()->put('phone', $request->phone_number);
        \session()->put('phone', $phone);
        \session()->put('request', $req);
        // \session()->put('images', $images);

        

        $rand = rand(1000, 9999);
        // $phone = $request['phone_number'];

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
        
        
        $sms = sms($phone, $rand);

        if (!$sms){
            return redirect()->back()->with('failedsms', 'متاسفانه سامانه دچار اختلال شده است، لطفا لحظاتی دیگر مجددا تلاش فرمایید');
        }


        return view('advertises.checkcode');


    }


    public function verify_post()
    {
        $url = explode('/', url()->previous());


        if (\session()->get('key') != 'valid' || end($url) != 'store') {
            Session::forget('key');
            abort('403', "کجا میای داداش؟");
        }


        $request = \session()->get('request');
        // $images = \session()->get('images');


        $posts_ad = new Post;

        $posts_ad->cbrand_id = $request['cbrand_id'];
        // $posts_ad->image_path = $images[0];
        
        if (isset($request['img_base64_one']))
            $posts_ad->image_path = $request['img_base64_one'];
        else
            $posts_ad->image_path = "noimage.jpg";

        
        $posts_ad->cmodel_id = $request['cmodel_id'];
        $posts_ad->year_id = $request['year_id'];
        $posts_ad->gearbox_id = $request['gearbox_id'];
        $distance = strtr($request['distance'], array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
        $posts_ad->distance = (int)$distance;
        $posts_ad->color_id = $request['color_id'];
        $posts_ad->cbody_id = $request['cbody_id'];

    
        if ($request['price_type'] == "agreed")
            $posts_ad->price = 0;
        else if ($request['price_type'] == "price") {
            if (array_key_exists('price', $request)) {
                $price = strtr($request['price'], array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
            } else {
                $price = "0";
            }
            // $posts_ad->price = (int)$price;
            $posts_ad->price = $price;
        }


        $posts_ad->subject = $request['subject'];
        $posts_ad->phone_number = $request['phone_number'];
        $posts_ad->email = $request['email'];
        $posts_ad->description = $request['description'];
        $posts_ad->state_id = $request['state_id'];
        $posts_ad->city_id = $request['city_id'];
        $posts_ad->location = $request['location'];
        $posts_ad->type = $request['type'];
        if (isset($request['meta'])) {
            $posts_ad->meta = $request['meta'];
        }
        if ($request['price_type'] == "trending") {
            $posts_ad->trending = true;
            $posts_ad->price = 0;
        } else {
            $posts_ad->trending = false;
        }
        $posts_ad->is_rent = '0';
            
            
            $cart = collect();
            
        
        $posts_ad->sort_id = Carbon::now();
        $posts_ad->save();
        
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
            $img->fit(300, 300);
            $img->orientate();
            $img->insert($watermark, 'bottom-left', 5, 5);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_one']);

            $image = new Image;
            $image->post_id = $posts_ad->id;
            $image->path = $request['img_base64_one'];
            $image->save();
            array_push($images , $request['img_base64_one']);
//            $images[] = $request['img_base64_one'];
        }else{
            $image = new Image;
            $image->post_id = $posts_ad->id;
            $image->path = "noimage.jpg";
            $image->save();
            array_push($images , "noimage.jpg");
        }

        if (isset($request['img_base64_two'])){
            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_two']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->fit(300, 300);
            $img->orientate();
            $img->insert($watermark, 'bottom-left', 5, 5);

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
            $img->fit(300, 300);
            $img->orientate();
            $img->insert($watermark, 'bottom-left', 5, 5);

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
            $img->fit(300, 300);
            $img->orientate();
            $img->insert($watermark, 'bottom-left', 5, 5);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_four']);

            $image = new Image;
            $image->post_id = $posts_ad->id;
            $image->path = $request['img_base64_four'];
            $image->save();
//            $images[] = $request['img_base64_four'];
            array_push($images , $request['img_base64_four']);

        }



        Session::forget(['key', 'request']);
        
        /////////////////////////// pusher /////////////////////////////////
        
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
                'brand' => $posts_ad->cbrand->name ,
                'subject' => $posts_ad->subject ,
                'mobile' => $posts_ad->phone_number,
                'is_rent' => 0];

        $pusher->trigger('new_post_channel' , 'new_post_event' , $data);


        \session()->put('store_post', 'آگهی شما با موفقیت ثبت شد');
        \session()->put('login', true);
        \session()->put('phone_number', $request['phone_number']);
        
        
        return view('advertises.preview' , compact('posts_ad' , 'images'));

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $mobile = \session()->get('phone_number' , '0');
        $user = UserPanel::where('phone_num' , '=' , $mobile)->first();
        
        $posts = Post::where([['id', '=', $id] , ['is_delete', '=', '0'] , ['is_active' , '=' , 1]])->first();
        

        if (!isset($posts))
            return redirect('/');
        if ($posts->is_active == 0) {
            if ($posts->is_rent == 0)
                return redirect('/advertises/all');
            else
                return redirect('/rent/all');
        }
        
        // $s = Carbon::now();
        
        $bind = [
            'id' => $id
        ];
        $visits = DB::select("
        select ip
        from visits
        where post_id = :id
        " , $bind);

        $ip = \request()->ip();

        $i = 0;
        $flag = 0;
        while ($i < count($visits) && $flag == 0){
            if ($visits[$i]->ip == $ip){
                $flag = 1;
            }
            $i++;
        }
        if ($flag == 0){
            $visit = new Visit();
            $visit->ip = $ip;
            $visit->post_id = $id;
            $visit->save();
        }
        

        if ($mobile == "0") {
            // return $mobile;
            $marks = unserialize(Cookie::get('marks'));

            $mark = "";
            if ($marks)
                if (in_array($id, $marks))
                    $mark = $id;
                else
                    $mark = "";
        } else {
            $mark = MarkPost::all()->where('user_id', '=', $user->id)->where('post_id', '=', $id)->first();
        }

        
        $images = Image::where('Post_id', $id)->get();

        $data = array(
            'cmodels' => [],
            'cbrands' => [],
            'posts' => [],
            'states' => [],
            'cities' => [],
            'mark' => $mark,
            'gearboxes' => [],
            'colors' => [],
            'years' => [],
            'cbodies' => [],
            'images' => []
        );



        $brand = $posts->cbrand_id;
        $model = $posts->cmodel_id;
        $type = $posts->type;
        $rent = $posts->is_rent;
        $state = $posts->state_id;
        // return $state;



        if ($rent == 1) {

            $related_posts = Post::where([['id', '<>', $id],
                ['is_active', '=', 1],
                ['type', '=', $type],
                ['is_rent', '=', 1],
                ['state_id', '=', $state],
                ['is_delete', '=', 0]])
                ->get(['id', 'color_id', 'subject', 'cbrand_id', 'type', 'image_path', 'is_rent', 'driver_status' , 'price' , 'trending'])->toArray();

//            $related_posts = collect($related_posts)->take(3);


        } else {
            $related_posts = Post::where([['is_active', '=', 1],
                ['cbrand_id', '=', $brand],
                ['is_delete', '=', 0],
                ['cmodel_id', '=', $model],
                ['type', '=', $type],
                ['is_rent', '=', 0],
                ['id', '<>', $id]])->orderBy('created_at' , 'desc')
                ->get(['id', 'color_id', 'subject', 'cbrand_id', 'type', 'image_path' , 'price' , 'trending'])->toArray();

        }
        
        $id_array = [];
        foreach($related_posts as $r){
            array_push($id_array , $r['id']);
        }


        if (count($related_posts) < 3){

            $postsa = Post::where([['id', '<>', $id],
                ['is_active', '=', 1],
                ['is_rent', '=', $rent],
                ['type', '=', $type],
                ['is_delete', '=', 0]])->whereNotIn('id' , $id_array)->orderBy('created_at' , 'desc')->take(3)->get();
                


                $a = count($related_posts);
            if(count($postsa) > 0){

            for ($i = $a; $i < 3 ; $i++){

                array_push($related_posts , $postsa[$i]);

            }                
                
            }


        }

        $related_posts = collect($related_posts)->unique('id');
        $related_posts = $related_posts->take(3);
        
        
        return view('advertises.show', compact('data', 'posts', 'images', 'related_posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sell()
    {
        return view('advertises.sell');
    }

    public function advertises_type($id , Request $request)
    {
        $posts = Post::query()
            ->where('is_active' , '=' , '1')
            ->where('is_rent' , '=' , 0)
            ->where('type' , '=' , $id);

        if (isset($request->term)){
            $posts = $posts->where('subject', 'LIKE', '%' . $request->term . '%')
                ->orWhere('description', 'LIKE', '%' . $request->term . '%')->where('type' , '=' , $id);
        }
        
        $posts_count = $posts->count();
        
        // $all_posts = $posts->orderBy('id' , 'desc')->paginate(20);
        $all_posts = $posts->orderBy('sort_id' , 'desc')->paginate(20);
        // return count($all_posts);
        
        if ($request->ajax()) {
//            $view = view('data',compact('posts'))->render();
            return response()->json(['data' => $all_posts]);
        }

        
        $term = (isset($request->term) ? $request->term : "");

        $types = Type::all()->take(9);

        $cmodels = DB::select("
            select *
            from cmodels");
        $cbrands = DB::select("
            select *
            from cbrands as c
            order by (c.name) asc");
        $colors = DB::select("
            select *
            from colors as c
            order by (c.name) asc");
        $years = DB::select("
            select *
            from years as y
            order by (y.name) desc");
        $gearboxes = DB::select("
            select *
            from gearboxes");
        $bodies = DB::select("
            select *
            from cbodies");
        $states = DB::select("
            select *
            from states");
            
        $now = Carbon::now()->addHours(3)->addMinutes(30)->subDays(2);
        
        $bind = ['typ' => $id , 'nt' => $now];
        $vip_posts = DB::select("
        SELECT posts.id, posts.subject, posts.price , posts.description , posts.image_path , posts.trending , vip_posts.created_at
        FROM posts
        INNER JOIN vip_posts ON posts.id = vip_posts.post_id
        where posts.is_active = 1 and posts.is_rent = 0 and posts.type = :typ and vip_posts.created_at >= :nt
        " , $bind);


        
        $data = array(
            'cmodels' => $cmodels,
            'cbrands' => $cbrands,
            'colors' => $colors,
            'term' => $term,
            'posts' => $all_posts,
            'vip' => $vip_posts,
            'count' => $posts_count,
            'years' => $years,
            'gearboxes' => $gearboxes,
            'bodies' => $bodies,
            'states' => $states,
            'types' => $types

        );



        return view('advertises.sell', $data);
    }
    
        public function image()
    {
        return "salam";

    }
    
}
