<?php

namespace App\Http\Controllers;

use App\Models\Cbody;
use App\Models\Cbrand;
use App\Models\City;
use App\Models\Cmodel;
use App\Models\Color;
use App\Models\ContactUs;
use App\Models\Image;
use App\Models\MarkPost;
use App\Models\Visit;
use App\Models\Post;
use App\Models\State;
use App\Models\Type;
use App\Models\User;
use App\Models\UserPanel;
use App\Models\VehicleMeta;
use App\Models\Year;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Lcobucci\JWT\Token;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\JWT;
use Pusher\Pusher;
use App\Models\Accessory;
use App\Models\Insurance;
use App\Models\ReportProblem;
use App\Models\Lux;


class CustomerController extends Controller
{

    private $config = [
        'post_image_url' => "/post_images/related_images_watermark/",  //cover image for post
        'path1' => "https://18charkh.com",  //domain of api
        'path2' => "/post_images/related_images_watermark/",   //related image path in post detail
        'path3' => "1.9.2",     //version of app
        'path4' => "",
        'path5' => "",
        'path6' => "",
    ];


    public $loginAfterSignUp = true;


    public function __construct()
    {
        auth()->setDefaultDriver('api');
    }

    public function check_phone_number(Request $request)
    {
        $rand = rand(1000, 9999);
        $phone = $request->input('phone_number');

        $user = UserPanel::where('phone_num', $phone)->first();
        if ($user) {
            $user->regCode = $rand;
        } else {
            $user = new UserPanel();
            $user->regCode = $rand;
            $user->phone_num = $phone;
        }
        $user->save();
        
        sms($phone, $rand);

        // $sms = new Sms();
        // $sms->sendcode($phone, $rand);

        return response()->json(['code' => $rand]);

    }

    public function register(Request $request)
    {
//        return Response()->json($request);
        $phone = $request->input('phone_number');

        $user = UserPanel::where('phone_num', $phone)->first();

//        return $token = $this->getJwtToken($user);
        if ($user) {
            if ($user->regCode == $request->input('code')) {
                $token = auth()->login($user);
                return $this->respondWithToken($token);
            }
            return response()->json(['error' => 'InvalidateCode'], 401);

        }
        return response()->json(['error' => 'Unauthorized'], 401);

    }


    public function login(Request $request)
    {
        $credentials = $request->only('phone_number');

        $user = UserPanel::where('phone_num', $credentials)->first();
        if (!$user) {
            return response()->json(['status' => 'User Not Registered']);
        }
        if ($user) {
            if ($user->regCode == $request->input('code')) {
                $token = auth()->login($user);
                return $this->respondWithToken($token);
            }
            return response()->json(['error' => 'InvalidateCode'], 401);

        }

        if (!$token = JWTAuth::fromUser($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function getAuthUser(Request $request)
    {
        return response()->json(auth()->user());
    }

    public function logout(Request $request)
    {

        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['success' => true, 'message' => 'به امید دیدار...']);


        // JWTAuth::invalidate($request->header('Authorization'));
        // return response()->json(['success' => true, 'message' => 'به امید دیدار...']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL()
        ]);
    }

    public function verifyUser(Request $request)
    {
        $phone = $request->phone_number;
        $user = UserPanel::where('phone_num', $phone);
        if (count($user) > 0) {
            if ($user->name && $user->password) {
                return response()->json($user);
            }
        }
        return response()->json(['message' => "user is not verify"]);
    }

    private function user(Request $request)
    {
        $user_token = $request->header('Authorization');
        $user = JWTAuth::toUser($user_token);
        return $user;
    }

    /// api ///

    public function base_params()
    {
        $colors = Color::all();
        $states = State::all();
        $cities = City::all();
        $cbrands = Cbrand::all();
        $cmodels = Cmodel::all();

        $types = Type::all()->toArray();
        // $types = Type::all()->sortByDesc('id');
        $types=array_reverse($types);



        $years = Year::orderBy('name' , 'desc')->get();
        // $years = DB::table('years')->orderBy('name' , 'desc');
        $cbodies = Cbody::all();
        $metas = VehicleMeta::all();
        $config = $this->config;
//        return $types;
        $base_params = array(
            'colors' => $colors,
            'states' => $states,
            'cities' => $cities,
            'cbrands' => $cbrands,
            'cmodels' => $cmodels,
            'types' => $types,
            'years' => $years,
            'config' => $config,
            'cbodies' => $cbodies,
            'metas' => $metas,
        );

        return response()->json($base_params);
    }

    public function config()
    {
        $config = $this->config;
        return response()->json($config);
    }

    public function posts(Request $request)
    {
        $input = $request->all();
//        return $input['colors'];

//        $posts = new Post();
        $posts = Post::where('is_active', 1)->orderBy('sort_id' , 'desc');

        if (isset($input["term"])) {
            $posts = $posts->where('subject', 'LIKE', '%' . $request->term . '%')
                ->orWhere('description', 'LIKE', '%' . $request->term . '%')
                ->orWhere('type', 'LIKE', '%' . $request->term . '%');
        }

        if (isset($input["types"]))
            $posts = $posts->where('type', $input["types"]);
        if (isset($input["states"]))
            $posts = $posts->where('state_id', $input["states"]);
        if (isset($input["brands"]))
            $posts = $posts->where('cbrand_id', $input["brands"]);
        if (isset($input["models"]))
            $posts = $posts->where('cmodel_id', $input["models"]);
        if (isset($input["years"]))
            $posts = $posts->where('year_id', $input["years"]);
        if (isset($input["gearboxes"]))
            $posts = $posts->where('gearbox_id', $input["gearboxes"]);
        if (isset($input["bodies"]))
            $posts = $posts->where('cbody_id', $input["bodies"]);
        if (isset($input["colors"]))
            $posts = $posts->where('color_id', $input["colors"]);

        $posts = $posts->select(['id', 'color_id', 'subject', 'cbrand_id', 'type', 'image_path', 'is_rent', 'driver_status' , 'price' , 'trending']);

        return response()->json($posts->paginate(20));
    }

    public function base_posts(Request $request)
    {
        $from = (int)$request->from;
        $to = (int)$request->to;
        
        if(isset($request->type)){
        
        $bind = [
            "from" => $from,
            "to" => $to,
            "t" => $request->type
            ];
                 
        $res = DB::select("
            select id , color_id , subject , cbrand_id , type , image_path , is_rent , driver_status , price , trending
            from posts
            where posts.is_active = 1 and posts.is_delete = 0 and type = :t
            limit :from , :to", $bind);
            
        }
        else{
            
        $bind = [
            "from" => $from,
            "to" => $to,
            ];
                 
        $res = DB::select("
            select id , color_id , subject , cbrand_id , type , image_path , is_rent , driver_status , price , trending
            from posts
            where posts.is_active = 1 and posts.is_delete = 0
            limit :from , :to", $bind);
            
        }



        // $res = DB::select("
        //     select id , color_id , subject , cbrand_id , type , image_path , is_rent , driver_status
        //     from posts
        //     where posts.is_active = 1 and posts.is_delete = 0
        //     limit $from , $to");
            


        return response()->json(['from' => $request->from, 'to' => $request->to, 'count' => count($res), 'data' => $res]);

    }

    public function post(Request $request)
    {
        
        $post = Post::where('id', '=', $request->id)->where('is_delete', '=', 0)->first();

        $images = Image::where('post_id', $request->id)->get();

        $post->setAttribute('images', $images);
        
        $bind = [
            'id' => $request->id
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
            $visit->post_id = $request->id;
            $visit->save();
        }        
        
        return response()->json($post);

    }
    //////////////////// old version ////////////////////////
    public function get_related_posts(Request $request)
    {
//        $posts = Post::class;
        
        $post = Post::find($request->post_id);
        $brand = $post->cbrand_id;
        $type = $post->type;
        $rent = $post->is_rent;


        if ($rent == 1) {

            $related_posts = Post::where([['id', '<>', $request->post_id],
                ['is_active', '=', 1],
                ['type', '=', $type],
                ['is_rent', '=', 1],
                ['is_delete', '=', 0]])
                ->get(['id', 'color_id', 'subject', 'cbrand_id', 'type', 'image_path' , 'is_rent' , 'driver_status'])->toArray();

            
        

            $related_posts = collect($related_posts)->take(8);

            return response()->json(['data' => $related_posts]);

        } else {
            $related_brands = Post::where([['is_active', '=', 1],
                ['cbrand_id', '=', $brand],
                ['is_delete', '=', 0],
                ['id', '<>', $request->post_id]])
                ->get(['id', 'color_id', 'subject', 'cbrand_id', 'type', 'image_path'])->toArray();

            $related_types = Post::where([['id', '<>', $request->post_id],
                ['is_active', '=', 1],
                ['type', '=', $type],
                ['is_delete', '=', 0]])
                ->get(['id', 'color_id', 'subject', 'cbrand_id', 'type', 'image_path' , 'is_rent' , 'driver_status']);


            $related_posts = array();

            foreach ($related_types as $type) {
                if (in_array($type, $related_brands)) {
                    array_push($related_posts, $type);
                }
            }
            $related_posts = array_merge($related_posts, $related_types->toArray(), $related_brands);
            
        
            
            $related_posts = collect($related_posts)->unique('id');
            $related_posts = $related_posts->take(8);
            
            return response()->json(['data' => $related_posts]);
        }

    }
    
    
    //////////////////// new version ////////////////////////
//    public function get_related_posts(Request $request)
//    {
//        $start = Carbon::now();
//        $bindings = [
//            'id' => $request->post_id
//        ];
//        $post = DB::select("
//            select cbrand_id , type , is_rent , state_id , cmodel_id
//            from posts
//            where id = :id", $bindings);
//        $type = $post[0]->type;
//        $brand = $post[0]->cbrand_id;
//        $is_rent = $post[0]->is_rent;
//        $state = $post[0]->state_id;
//        $model = $post[0]->cmodel_id;
//
//        $posts = DB::select('
//            select id , state_id , color_id , subject , cbrand_id, type, image_path , is_rent , driver_status , cmodel_id
//            from posts
//            where id <> :id
//            ', $bindings);
//
//        $related = array();
//        $counter = 0;
//        foreach ($posts as $post) {
//
//            do {
//
//                if ($post->state_id == $state && $post->type == $type && $post->cbrand_id == $brand) {
//                    $related[] = $post;
//                    $counter++;
//                    var_dump('first');
//                    break;
//                }
//                if ($post->state_id == $state && $post->type == $type && $post->cmodel_id == $model) {
//                    $related[] = $post;
//                    $counter++;
//                    var_dump('second');
//                    break;
//                }
//                if ($post->state_id == $state && $post->type == $type) {
//                    $related[] = $post;
//                    $counter++;
//                    var_dump('third');
//                    break;
//                }
//                if ($post->state_id == $state) {
//                    $related[] = $post;
//                    $counter++;
//                    var_dump('fourth');
//                }
//                var_dump('ok');
//            } while (false);
//            var_dump('oooooooook');
//
//            if ($counter == 8) {
//                break;
//            }
//        }
//        $end = Carbon::now();
//        return Carbon::parse($start)->diffInMilliseconds($end);
//
//            return response()->json(['data' => $related]);
////        }
//    }


    public function store_post(Request $request)
    {
        
        // return response()->json(count($request->images));
        
        $posts_ad = new Post;

        $posts_ad->cbrand_id = $request->cbrand_id;
        if (isset($request->images[0]['image_name']))
            $posts_ad->image_path = $request->images[0]['image_name'];
        else
            $posts_ad->image_path = 'noimage.jpg';
        $posts_ad->cmodel_id = $request->cmodel_id;
        $posts_ad->year_id = $request->year_id;
        $posts_ad->gearbox_id = $request->gearbox_id;
        $posts_ad->distance = $request->distance;
        $posts_ad->color_id = $request->color_id;
        $posts_ad->cbody_id = $request->cbody_id;
        $posts_ad->price = $request->price;
        $posts_ad->subject = $request->subject;
        $posts_ad->phone_number = $request->phone_number;
        $posts_ad->email = $request->email;
        $posts_ad->description = $request->description;
        $posts_ad->state_id = $request->state_id;
        $posts_ad->city_id = $request->city_id;
        $posts_ad->trending = $request->trending;
        $posts_ad->is_pending = true;
        $posts_ad->is_active = false;
        $posts_ad->type = $request->type;
        if ($request->type === '1') {
            $posts_ad->meta = $request->meta;
        }
        if (isset($request->trending)) {
            $posts_ad->trending = true;
        } else {
            $posts_ad->trending = false;
        }
        $posts_ad->is_rent = $request->is_rent;
        if ($request->is_rent == 1) {
            $posts_ad->driver_status = $request->input('driver_status');
        } else {
            $posts_ad->driver_status = '0';
        }
        $posts_ad->sort_id = Carbon::now();
        $posts_ad->save();
        

        if (isset($request->images[0]['image_name'])){
            
            foreach ($request->images as $image) {

            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $image['image_name']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->fit(300, 300);
            $img->insert($watermark, 'bottom-left', 5, 5);

            $img->fit(300, 300);

            $success = $img->save('post_images/related_images_watermark/' . $image['image_name']);

            $new_image = new Image;
            $new_image->post_id = $posts_ad->id;
            $new_image->path = $image['image_name'];
            $new_image->save();
            
            }
            
        }else{
            
            $new_image = new Image;
            $new_image->post_id = $posts_ad->id;
            $new_image->path = "noimage.jpg";
            $new_image->save();
            
        }
        
        
        
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
                'is_rent' => $posts_ad->is_rent];

        $pusher->trigger('new_post_channel' , 'new_post_event' , $data);
        

        return response()->json(['success' => true, 'message' => 'آگهی شما ثبت شد و بعد از تایید کارشناسان 18چرخ به نمایش درخواهد آمد']);

    }

    public function store_image(Request $request)
    {
    
        $file = base64_decode($request->image);

        $imageName = "image" . time() . '.' . 'jpg';

        $source = file_put_contents('post_images/related_images/' . $imageName, $file);


        if ($source)
            return response()->json(['image_name' => $imageName, 'code' => '200']);
        else
            return response()->json(['code' => '401']);
    }

    public function destroy_image(Request $request) // just for remove image from storepost page
    {
        Storage::delete('/public/related_images_watermark/' . $request->name);
        return response()->json(['success' => true, 'message' => "عکس با موفقیت حذف شد"]);
    }

    public function my_posts(Request $request)
    {
        // $user = $this->user($request);
        $user = auth()->user();
        $posts = Post::select('id', 'color_id', 'subject', 'cbrand_id', 'type', 'image_path', 'is_active', 'is_pending', 'admin_response')->
                    where('phone_number', $user->phone_num)->where('own_delete' , 0)
        ->orderBy('created_at', 'DESC')
        ->get();
        
        foreach($posts as $post){
            $post->setAttribute('visit_count', $post->visits());
        }
        
        return response()->json(['data' => $posts]);

    }

    public function mark_post(Request $request)
    {
        // $user = $this->user($request);
        $user = auth()->user();

        $user_id = $user->id;
        $mark = MarkPost::all()->where('post_id', '=', $request->post_id)->where('user_id', '=', $user_id);
        if (count($mark) == 0) {
            $markpost = new MarkPost;
            $markpost->post_id = $request->post_id;
            $markpost->user_id = $user_id;
            $markpost->save();
            return response()->json(['message' => 'mark']);
        } else {
            $markk = $mark->first();
            $markk->delete();
            return response()->json(['message' => 'unmark']);
        }

        return response()->json(['message' => 'another']);
    }

    public function favorite_posts(Request $request)
    {
        // $user = $this->user($request);
        $user = auth()->user();

        $user_id = $user->id;

        $favorites = DB::table('posts')
            ->select('posts.id', 'color_id', 'subject', 'cbrand_id', 'type', 'image_path')
            ->join('mark_posts', 'posts.id', '=', 'mark_posts.post_id')
            ->where('mark_posts.user_id', '=', $user_id)
            ->where('posts.is_active', '=', 1)
            ->where('posts.is_delete', '=', 0)
            ->orderBy('id', 'desc')->get();

        return response()->json(['data' => $favorites]);
    }

    public function destroy_post(Request $request)
    {
        // $user = $this->user($request);
        $user = auth()->user();
        $user_id = $user->id;

        $post = Post::where('id', $request->post_id)
            ->where('phone_number', $user->phone_num)->first();
            if(!isset($post))
                return response()->json(['success' => false]);
        $post->is_delete = 1;
        $post->own_delete = 1;
        $post->is_active = 0;
        $post->save();
//        $imgs = Image::where(['post_id' => $request->post_id, 'user_id' => $user_id]);
//        foreach ($imgs as $img) {
//            $img->delete();
//        }
        return response()->json(['success' => true, 'message' => 'آگهی شما با موفقیت حذف شد']);
    }

    public function search(Request $request)
    {
        
        $posts = Post::query()
            ->where('is_active', '=', 1)
            ->where('is_delete', '=', 0)
            ->where('subject', 'LIKE', '%' . $request->term . '%')
            ->orWhere('description', 'LIKE', '%' . $request->term . '%')
            ->orWhere('type', 'LIKE', '%' . $request->term . '%');

        // return response()->json(['success' => true, 'message' => 'آگهی شما با موفقیت حذف شد']);
        return $posts->get();
    }

    public function contact_us(Request $request)
    {
        $message = new ContactUs();
        $message->subject = $request->title;
        $message->content = $request->description;
        $message->phone_number = $request->phone_number;
        $message->email = $request->email;
        $message->save();
        return response()->json(['success' => true, 'message' => 'پیام شما ثبت شد. با تشکر از نظردهی شما']);
    }

    public function update_post(Request $request)
    {
        
        // return $request->remove_images;
        $phone = auth()->user()->phone_num;
        
        
        $posts_ad = Post::find($request->id);
        
        if($posts_ad->phone_number != $phone)
            return response()->json(['success' => false, 'message' => 'این آگهی برای شما نیست']);
        
        if (isset($request->images[0]['image_name']))
            $posts_ad->image_path = $request->images[0]['image_name'];
        else
            $posts_ad->image_path = 'noimage.jpg';

        $posts_ad->cmodel_id = $request->cmodel_id;
        $posts_ad->cbrand_id = $request->cbrand_id;
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

        $posts_ad->is_pending = true;
        $posts_ad->is_active = false;
        $posts_ad->type = $request->type;
        if ($request->type === '1') {
            $posts_ad->meta = $request->meta;
        }
        if (isset($request->trending)) {
            $posts_ad->trending = true;
        } else {
            $posts_ad->trending = false;
        }
        $posts_ad->is_rent = $request->is_rent;
        if ($request->is_rent == 1) {
            $posts_ad->driver_status = $request->input('driver_status');
        } else {
            $posts_ad->driver_status = '0';
        }

        $posts_ad->save();

        ////////
        /// first remove all images from DB
        $old_images = Image::where('post_id', $request->id)->get();
        

        foreach ($old_images as $image) {
            $image->delete();
        }
        /////////
        /// then destroy remove_images from Disk
        if (count($request->remove_images) > 0) {
            foreach ($request->remove_images as $image) {
                if($image != null){
                        Storage::delete('/public/related_images_watermark/' . $image['image_name']);
                        Storage::delete('/public/related_images/' . $image['image_name']);
                }

            }
        }
        ////////
        /// then add all images to DB
        // foreach ($request->images as $image) {
        //     $new_image = new Image;
        //     $new_image->post_id = $posts_ad->id;
        //     $new_image->path = $image['image_name'];
        //     $new_image->save();
        // }
        /////////

        if (isset($request->images[0]['image_name'])){
            
            foreach ($request->images as $image) {

            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $image['image_name']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->fit(300, 300);
            $img->insert($watermark, 'bottom-left', 5, 5);

            $img->fit(300, 300);

            $success = $img->save('post_images/related_images_watermark/' . $image['image_name']);

            $new_image = new Image;
            $new_image->post_id = $posts_ad->id;
            $new_image->path = $image['image_name'];
            $new_image->save();
            
            }
            
        }else{
            
            $new_image = new Image;
            $new_image->post_id = $posts_ad->id;
            $new_image->path = "noimage.jpg";
            $new_image->save();
            
        }        
        

        return response()->json(['success' => true, 'message' => 'آگهی شما با موفقیت ویرایش شد']);

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
        
        return $service->orderBy('created_at' , 'desc')->get();
        
    }    
    
    public function get_ads_lux(Request $request){
        
        $serv = Lux::query();
        
        return response()->json(['success' => true, 'data' => $this->services($serv , $request) ]);
    }
    
    public function get_ads_insurance(Request $request){
        
        $serv = Insurance::query();
        
        return response()->json(['success' => true, 'data' => $this->services($serv , $request) ]);
    }    
    
    public function get_ads_accessory(Request $request){
        
        $serv = Accessory::query();
        
        return response()->json(['success' => true, 'data' => $this->services($serv , $request) ]);
    } 
    
    public function report_problem(Request $request){
        
        $user_id = auth()->id();
        
        $reports = ReportProblem::where('user_id' , $user_id)->latest()->first();
        $posts = Post::find($request->post_id);
        if(!isset($posts) || $posts->is_active == 0){
            return response()->json(['success' => false, 'message' => 'این آگهی وجود ندارد']);
        }
        
        if(isset($reports)){
            
            $last_sent = $reports->created_at;
            
            $now = Carbon::now();
            
            $diff = $now->diffInHours($last_sent);
            
            if($diff < 6){
                return response()->json(['success' => false, 'message' => 'شما مجاز به ثبت گزارش نیستید']);
            }
        }
        
        if($request->content == null){
                return response()->json(['success' => false, 'message' => 'محتوای گزارش را وارد کنید']);            
        }
        
        $report = new ReportProblem();
        $report->post_id = $request->post_id;
        $report->user_id = $user_id;
        $report->content = $request->content;
        
        if($report->save()){
            return response()->json(['success' => true, 'message' => 'گزارش شما ثبت شد']);
        }
        
        
        
    }
    

}
