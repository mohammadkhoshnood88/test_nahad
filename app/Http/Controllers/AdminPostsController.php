<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Cmodel;
use App\Models\Cbody;
use App\Models\Cbrand;
use App\Models\Color;
use App\Models\WebSite;
use App\Models\InstagramId;
use App\Models\State;
use App\Models\City;
use App\Models\Type;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
// use mysql_xdevapi\Result;



class AdminPostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        dd(Gate::allows('isEditor'));
//        if (!Gate::none(['isAdmin', 'isOwner' , 'isIssuer'])) {
//            return abort(403 , 'شما به این بخش دسترسی ندارید');
//        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adm_manage(Request $request)
    {

        if (!Gate::any(['isAdmin', 'isOwner', 'isIssuer'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید');
        }
        
        // $post = Post::where('id', '=', '1587')->first();
        // return $post;


        $posts = Post::where('is_rent', '=', '0')
        ->orderBy('is_delete' , 'asc')
        ->orderBy('is_active' , 'asc')
        ->orderBy('created_at' , 'desc')
        ->paginate(8);
        

        if ($request->ajax()) {
            return response()->json(['data' => $posts]);
        }

        $data = array(
            // 'cmodels' => $cmodels,
            // 'cbrands' => $cbrands,
            'posts' => $posts
        );


        return view('admin.posts.adm_manage', $data);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return "salam store";
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::any(['isAdmin', 'isOwner', 'isIssuer'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید');
        }
        $posts = Post::find($id);
        $images = Image::where('post_id', $id)->get();
        
        // return $images;

//        return $posts->index(1);
        // print_r( $images);
        // return;
//        return
        $data = array(
            'posts' => $posts,
            'images' => $images,
            'image_size' => sizeof($images)
        );

        return view('admin.posts.adm_edit', $data);
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
        
        if (!Gate::any(['isAdmin', 'isOwner', 'isIssuer'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید');
        }

        $this->validate(
            $request,
            ['description' => 'required',
                'subject' => 'required',
                'phone_number' => 'required',
                ],

            ['description.required' => 'موضوع آگهی الزامی می باشد.',
                'subject.required' => 'عنوان آگهی الزامی می باشد.',
                'phone_number.required' => 'شماره تلفن الزامی می باشد.']


        );

        if ($request->has('is_active') && !$request->has('is_pending'))
            return back()->with(['error' => "اشتباه در تایید آگهی رخ داده است"]);

        $posts_ad = Post::find($id);
        $last_active = $posts_ad->is_active;


        // Update Posts

        $posts_ad->price = $request->input('price');
        $posts_ad->subject = $request->input('subject');
        $posts_ad->phone_number = $request->input('phone_number');
        $posts_ad->email = $request->input('email');
        $posts_ad->description = $request->input('description');
        $posts_ad->admin_response = $request->input('admin_response');
        $posts_ad->image_path = $request['img_base64_one'];

        $posts_ad->is_pending = $request->has('is_pending');
        $posts_ad->is_active = $request->has('is_active');


        // check times are correct

        $confirm = Carbon::parse($this->convertDate($request->confirm_at));
        $expire = Carbon::parse($this->convertDate($request->expire_at));
        if ($expire->lt($confirm)) {
            return back()->with(['error' => "تاریخ انقضا نامعتبر است"]);
        }
        //

        if ($request->has('is_active')) {
            //confirm time handle

            $posts_ad->confirm_at = $this->convertDate($request->confirm_at);

            // expire time handle

            if (isset($request->expire_at_status)) {
                $expiree = $this->convertDate($request->expire_at);
                $posts_ad->expire_at = $expiree;
            }elseif (empty($posts_ad->expire_at)){
                $expiree = Carbon::parse($confirm)->addMonth();
                $posts_ad->expire_at = $expiree;
            }
        }
        ////////////////////////////// short link /////////////////////////////
        
        if($posts_ad->shortlink == null){

        $links = DB::select('
            select shortlink
            from posts
            ');

        $l = [];
        foreach ($links as $link){
            $l[] = $link->shortlink;
        }

        $sl = Str::random(8);
        $flag = 0;
        $i = 0;

        while (!$flag){

            if (!in_array($sl , $l)){
                $flag = 1;
            }
            else{
                $sl = Str::random(8);
            }
            $i++;
        }
        $posts_ad->shortlink = $sl;
        
            
        }
        
        $posts_ad->save();
        
        ////////////////////////////////////////////////////////////////////////

        
        

        $posts_ad->save();
        
        
        
        $images = Image::where('post_id', '=', $id)->get();
        
        // return $images;
        $a_images = $images->pluck('path')->toArray();


        if (isset($request['img_base64_one']) && $request['img_base64_one'] != "noimage.jpg" && $request['img_base64_one'] != $images[0]->path){
            

            
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
     
        // if ($request['img_base64_two'] != "") {
        if ($request['img_base64_two'] != "" && !in_array($request['img_base64_two'] , $a_images)){

            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_two']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(300 , 300);
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
                
        }

        // if ($request['img_base64_three'] != ""){
        if ($request['img_base64_three'] != "" && !in_array($request['img_base64_three'] , $a_images)){
            // if(isset($images[2]))
            //     $images[2]->delete();
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
        /////////////////////////////////   sms  ///////////////////////////////

    

        if($last_active == "0" && $posts_ad->is_active == 1){
            
            $message = urlencode("کاربر گرامی\nآگهی شما با موفقیت در سامانه 18 چرخ تایید گردید.");
            
            $sms = new Sms();
            $sms->submit($posts_ad->phone_number , $message);

        }
        
        if($request['reject']){
        
            $message = "";
            
            switch ($request['reject_content']) {
                    case "0":
                    
                        break;
                        
                    case "1":
                        
                            $message = urlencode("کاربر گرامی\nآگهی شما به دلیل انتخاب تصویر نامناسب در سامانه 18 چرخ منتشر نشد. لطفا نسبت به ویرایش آن اقدام نمایید.");
            
                        break;
                        
                    case "2":
                        
                        $message = urlencode("کاربر گرامی\nآگهی شما به دلیل رعایت نکردن قوانین در سامانه 18 چرخ منتشر نشد. لطفا نسبت به ویرایش آن اقدام نمایید.");

                        break;
                        
                    case "3":
                        
                        $message = urlencode("کاربر گرامی\nآگهی شما به دلیل مناسب نبودن متن با شئونات اسلامی در سامانه 18 چرخ منتشر نشد. لطفا نسبت به ویرایش آن اقدام نمایید.");

                        break;                        
                        
                    default:
                        
                        $message = urlencode("کاربر گرامی\nآگهی شما به دلایل دیگر در سامانه 18 چرخ منتشر نشد. لطفا نسبت به ویرایش آن اقدام نمایید.");

                                }

            $sms = new Sms();
            $sms->submit($posts_ad->phone_number , $message);                                
                                
                                
        }        
        
        

            
        ////////////////////////////////////////////////////////////////////////

        return redirect('/admin/adm_manage')->with('success', 'آگهی مورد نظر با موفقیت ویرایش گردید');

    }

    protected function convertDate($date)
    {
        $aa = CalendarUtils::convertNumbers($date, true);

        $year = substr($aa, '0', '4');
        $month = substr($aa, '5', '2');
        $day = substr($aa, '8', '2');

        $result = CalendarUtils::toGregorian($year, $month, $day);
        $re = $result[0] . '-' . $result[1] . '-' . $result[2] . ' ' . "00:00:00";
        return $re;
    }

    public function uploadFile(Request $request)
    {

        if (!Gate::any(['isAdmin', 'isOwner', 'isIssuer'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید');
        }

        $imageId = $request["imageId"];
        $postId = $request["postId"];
        $image_path = "";

        if ($request->hasFile('image')) {
            // Get filename with extension
//            $filenameWithExt = $request->file('image')->getClientOriginalName();
//            // Get just filename
//            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
//            // Get just ext
//            $extension = $request->file('image')->getClientOriginalExtension();
//            // Filename to store
//            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
//            // Upload Image
//            $path = $request->file('image')->storeAs('public/related_images', $fileNameToStore);

//            $path = $request->file('img-upload-1')->storeAs('public/related_images', $fileNameToStore);

            $file = $request->file('image');
            $filename = time() . $file->getClientOriginalName();
            $file->move('post_images/related_images', $filename);

            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $filename);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(600, 600);
            $img->insert($watermark, 'bottom-left', 10, 10);


            $success = $img->save('post_images/related_images_watermark/' . $filename);

        }


        $image = Image::find($imageId);
        if ($imageId == -1 && $image_path != "") {
            $image = new Image;
            $image->post_id = $postId;
            $image->path = $image_path;
            $image->save();
        } else if ($image_path != "") {
            $image->post_id = $postId;
            $image->path = $image_path;
            $image->save();
        }

        return response()->json(array('success' => true, "imageId" => $image->id), 200);

    }

    public function deleteFile(Request $request)
    {

        if (!Gate::any(['isAdmin', 'isOwner', 'isIssuer'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید');
        }

        $imageId = $request["imageId"];
        $postId = $request["postId"];

        Image::where('id', $imageId)->where('post_id', $postId)->delete();

        return response()->json(array('success' => true), 200);

    }

    // public function authenticate(Request $request)
    // {
    
    //     $validator = $request->validate([
    //         'email' => 'required',
    //         'password' => 'required|min:8'
    //     ]);

    //     $email = $request['email'];
    //     $password = $request['password'];

    //     if (Auth::attempt(['email' => $email, 'password' => $password])) {
    //         return redirect('/admin/dashboard');
    //     } else {
    //         return redirect('/login');
    //     }
    // }
    /////////////////////////////////  new post from admin panel  /////////////////////////////////////////////////
    
    public function create_new_post()
     {
        
        if (!Gate::any(['isAdmin', 'isOwner', 'isIssuer'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید');
        }

        $types = Type::all()->take(8);
        
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
            'gearboxes' => $gearboxes,
            'colors' => $colors,
            'years' => $years,
            'cbodies' => $cbodies,
            'types' => $types
        );


        return view('admin.posts.create_new_post', $data);
    }

    public function store_new_post(Request $request)
    {
     
    //  return $request;   
    
        if (!Gate::any(['isAdmin', 'isOwner', 'isIssuer'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید');
        }
        

        $posts_ad = new Post;

        $posts_ad->cbrand_id = $request['cbrand_id'];
        
        if ($request['img_base64_one'] != null)
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
            if ($request['price'] != null) {
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
            
            
            
        $posts_ad->sort_id = Carbon::now();
        $posts_ad->save();
        
        if ($request['instagram_id'] != null) {

            $insta = new InstagramId;
            $insta->post_id = $posts_ad->id;
            $insta->instagram_id = $request['instagram_id'];
            $insta->save();
        }

        if ($request['website'] != null) {

            $web = new WebSite();
            $web->post_id = $posts_ad->id;
            $web->website = $request['website'];
            $web->save();
        }

        
        

            $images = array();
        if ($request['img_base64_one'] != null){
            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_one']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(300, 300);
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

        if ($request['img_base64_two'] != null){
            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_two']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(300, 300);
            $img->insert($watermark, 'bottom-left', 5, 5);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_two']);

            $image = new Image;
            $image->post_id = $posts_ad->id;
            $image->path = $request['img_base64_two'];
            $image->save();
            array_push($images , $request['img_base64_two']);


        }

        if ($request['img_base64_three'] != null){
            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_three']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(300, 300);
            $img->insert($watermark, 'bottom-left', 5, 5);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_three']);

            $image = new Image;
            $image->post_id = $posts_ad->id;
            $image->path = $request['img_base64_three'];
            $image->save();
//            $images[] = $request['img_base64_three'];
            array_push($images , $request['img_base64_three']);

        }

        if ($request['img_base64_four'] != null){
            $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $request['img_base64_four']);
            $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
            $img->resize(300, 300);
            $img->insert($watermark, 'bottom-left', 5, 5);

            $success = $img->save('post_images/related_images_watermark/' . $request['img_base64_four']);

            $image = new Image;
            $image->post_id = $posts_ad->id;
            $image->path = $request['img_base64_four'];
            $image->save();
//            $images[] = $request['img_base64_four'];
            array_push($images , $request['img_base64_four']);

        }

        return redirect('/admin/adm_manage');
        // return view('admin.preview' , compact('posts_ad' , 'images'));

    }
}
