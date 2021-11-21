<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\ContactUs;
use App\Models\Lux;
use App\Models\Insurance;
use App\Models\Rent;
use App\Models\TechCheckUp;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Cmodel;
use App\Models\Cbrand;
use App\Models\State;
use App\Models\Chat;
use App\Models\City;
use App\Models\Type;
use App\Models\PostExtras;
use App\Models\Payment;
use App\Models\Cbody;
use App\Models\Year;
use App\Models\CarIntro;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Pusher\Pusher;
use Carbon\Carbon;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware(['can:isAdmin' , 'can:isOwner'])->only('adm_brand', 'adm_model'
//            , 'storecmodel', 'add_brand', 'storebrand', 'adm_cbody', 'storecbody', 'adm_year'
//            , 'storeyear', 'adm_state', 'storestate', 'adm_city', 'storecity', );
        $this->middleware('can:isOwner')->only('adm_user', 'adm_showuser'
            , 'update_user');
    }

    public function dashboard()
    {

        $posts = Post::all();
        $actives = Post::where('is_active', '1')->get();
        
        $pendings_post = Post::where([['is_pending', '1'] , ['is_active', '0'] , ['is_delete', '0']  , ['own_delete', '0'] , ['is_rent', '0']])->get();
        $pendings_rent = Post::where([['is_pending', '1'] , ['is_active', '0'] , ['is_delete', '0']  , ['own_delete', '0'] , ['is_rent', '1']])->get();

        $deactives = Post::where([['is_active', '0'] , ['is_delete', '1']])->get();
        
        $lux = count(Lux::where([['is_active', '0'] , ['is_delete', '0']])->get());
        $accessory = count(Accessory::where([['is_active', '0'] , ['is_delete', '0']])->get());
        $insurance = count(Insurance::where([['is_active', '0'] , ['is_delete', '0']])->get());

        $actives = count($actives);
        $pendings = count($pendings_rent) + count($pendings_post);
        $deactives = count($deactives);
        $all = count($posts);
        
        $new_msg = DB::select("
            select subject ,content
            from contact_us
            where checked = 0
        ");
        
    
        $new_pay = DB::select("
            select post_id , amount 
            from payments
            where checked = 0
            limit 5
        ");
        
        
        \session()->put('new_msg', array_slice($new_msg, 0, 5, true));
        \session()->put('new_pay', $new_pay);
        \session()->put('task_deactives_post', count($pendings_post) / $all * 100);
        \session()->put('task_deactives_rent', count($pendings_rent));
        \session()->put('task_new_msg', count($new_msg));
        
        $data = array(
            'lux' => $lux,
            'accessory' => $accessory,
            'insurance' => $insurance,
            'posts' => $all,
            'actives' => $actives,
            'pendings' => $pendings,
            'deactives' => $deactives
        );


        return view('admin.dashboard', $data);
    }

    public function adm_register()
    {

        $cmodels = Cmodel::all();
        $cbrands = Cbrand::all();
        $posts = Post::all();

        $data = array(
            'cmodels' => $cmodels,
            'cbrands' => $cbrands,
            'posts' => $posts
        );


        return view('admin.adm_register', $data);
    }


    public function adm_brand()
    {
        
        if (!Gate::any(['isAdmin', 'isOwner'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید.');
        }

        $brands = Cbrand::orderby('name', 'asc')->get();


        return view('admin.adm_brand')->with('brands', $brands);
    }


    public function adm_model()
    {
        if (!Gate::any(['isAdmin', 'isOwner'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید.');
        }

        $cmodels = Cmodel::all();
        $cbrands = Cbrand::orderby('name', 'asc')->get();

        $data = array(
            'cmodels' => $cmodels,
            'cbrands' => $cbrands,
        );


        return view('admin.adm_model', $data);
    }

    public function storecmodel(Request $request)
    {
        if (!Gate::any(['isAdmin', 'isOwner'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید.');
        }

        $newmodel = new Cmodel;
        $newmodel->name = $request->input('cmodel_subject');
        $newmodel->cbrand_id = $request->input('cbrand_id');

        $newmodel->save();

        return;
    }

    public function add_brand()
    {
        $countries = Cbrand::all()->pluck('country')->toArray();
        $countries = array_unique($countries);
        
        return view('admin.add_brand' , ['countries' => $countries]);
    }
    
    public function edit_brand($id)
    {
        
        $countries = Cbrand::all()->pluck('country')->toArray();
        $countries = array_unique($countries);
        $brand = Cbrand::find($id);

        return view('admin.edit_brand' , ['countries' => $countries , 'brand' => $brand]);
    }
    
    public function add_carIntro()
    {
        $brands = Cbrand::all();
        $intros = CarIntro::all()->sortBydesc('created_at');
        $intros = [];
        
        return view('admin.add_carIntro' , ['brands' => $brands , 'intros' => $intros]);
    }
    
    private function store_in_model($intro , $request){
        
        $intro->model_id = $request->model;
        $intro->engine_type = $request->engine_type;
        $intro->brake = $request->brake;
        $intro->engine_volume = $request->engine_volume;
        $intro->gearbox = $request->gearbox;
        $intro->fuel_type = $request->fuel_type;
        $intro->engine_power = $request->engine_power;
        $intro->suspension = $request->suspension;
        $intro->gear_count = $request->gear_count;
        $intro->cylinder_count = $request->cylinder_count;
        $intro->pollution = $request->pollution;
        $intro->torque = $request->torque;
        $intro->fuel_system = $request->fuel_system;
        $intro->save();
        return true;
    }
    
    public function store_car_intro(Request $request){
        
        $intro = CarIntro::where('model_id' , $request->model)->first();
        
        if(isset($intro)){
            $a = $this->store_in_model($intro , $request);
        }
        else{
            $new_intro = new CarIntro();
            $b = $this->store_in_model($new_intro , $request);
        }
        return back();
    }
    
    public function remove_car_intro(Request $request){
        $intro = CarIntro::where('id' , $request->intro_id)->first();
        $intro->delete();
        return response()->json(['success' => true]);
    }

    public function storebrand(Request $request)
    {
        
        if (!Gate::any(['isAdmin', 'isOwner'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید.');
        }

        $newbrand = new Cbrand;
        $newbrand->name = $request->input('brand');
        $newbrand->country = $request->input('country');
        $newbrand->description = $request->input('description');
        
        if ($request->hasFile('country_img')) {
            
        $file_country = $request->file('country_img');
            
        $img = \Intervention\Image\Facades\Image::make($request->file('country_img'));
            
        $fileNameToStore = $request->country . ".png";
            
        $success = $img->save('brandIntro/' . $fileNameToStore);            
            

        } else {
            
        $countries = Cbrand::all()->pluck('country')->toArray();
        
        if(in_array($request->country , $countries) && isset($request->country)){
            $fileNameToStore = $request->country . ".png";
        }else{
            $fileNameToStore = $request->country . ".png";
        }
            
        }
        $newbrand->country_img = $fileNameToStore;
        
        if ($request->hasFile('brand_img')) {
            
        $file_brand = $request->file('brand_img');
            
        $img = \Intervention\Image\Facades\Image::make($request->file('brand_img'));
            
        $brand_img = "logo" . $file_brand->getClientOriginalName();
            
        $success = $img->save('brandIntro/' . $brand_img);
            
        } else {
            $brand_img = null;
        }
        $newbrand->brand_img = $brand_img;        

        $newbrand->save();

        return redirect('/admin/adm_brand');
    }
    

    public function updatebrand(Request $request , $id)
    {
        if (!Gate::any(['isAdmin', 'isOwner'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید.');
        }

        $brand = Cbrand::find($id);
        $brand->name = $request->input('brand');
        $brand->country = $request->input('country');
        $brand->description = $request->input('description');
        
        $countries = Cbrand::all()->pluck('country')->toArray();
        
        if(in_array($request->country , $countries) && isset($request->country)){
            $brand->country_img = $request->country . ".png";
        }
        else{
            
            if ($request->hasFile('country_img')) {
            
                $file_country = $request->file('country_img');
            
                $img = \Intervention\Image\Facades\Image::make($request->file('country_img'));
            
                $fileNameToStore = $request->country . ".png";
            
                $success = $img->save('brandIntro/' . $fileNameToStore);            
            
            } else {
                $fileNameToStore = null;
            }
                $brand->country_img = $fileNameToStore;
            
        }
    
        
        if ($request->hasFile('brand_img')) {
            
        $file_brand = $request->file('brand_img');
            
        $img = \Intervention\Image\Facades\Image::make($request->file('brand_img'));
            
        $brand_img = "logo" . $file_brand->getClientOriginalName();
            
        $success = $img->save('brandIntro/' . $brand_img);
            
        } else {
            $brand_img = null;
        }
        $brand->brand_img = $brand_img;

        $brand->save();

        return redirect('/admin/adm_brand');
    }
    

    public function adm_cbody()
    {
        if (!Gate::any(['isAdmin', 'isOwner'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید.');
        }

        $cbodies = Cbody::orderby('name', 'asc')->get();

        return view('admin.adm_cbody')->with('cbodies', $cbodies);
    }

    public function storecbody(Request $request)
    {
        if (!Gate::any(['isAdmin', 'isOwner'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید.');
        }

        $newcbody = new Cbody;
        $newcbody->name = $request->input('cbody_subject');

        $newcbody->save();

        return;
    }

    public function adm_year()
    {

        if (!Gate::any(['isAdmin', 'isOwner'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید.');
        }

        $year = Year::orderby('name', 'asc')->get();

        return view('admin.adm_year')->with('year', $year);
    }

    public function storeyear(Request $request)
    {

        if (!Gate::any(['isAdmin', 'isOwner'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید.');
        }

        $newyear = new Year;
        $newyear->name = $request->input('year_subject');

        $newyear->save();

        return;
    }

    public function adm_state()
    {
        if (!Gate::any(['isAdmin', 'isOwner'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید.');
        }

        $state = State::orderby('name', 'asc')->get();

        return view('admin.adm_state')->with('state', $state);
    }

    public function storestate(Request $request)
    {

        if (!Gate::any(['isAdmin', 'isOwner'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید.');
        }

        $newstate = new State;
        $newstate->name = $request->input('state_subject');

        $newstate->save();

        return;
    }

    public function adm_city()
    {
        if (!Gate::any(['isAdmin', 'isOwner'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید.');
        }

        $cities = City::orderby('name', 'asc')->get();
        $states = State::all();

        $data = array(
            'cities' => $cities,
            'states' => $states,
        );


        return view('admin.adm_city', $data);
    }

    public function storecity(Request $request)
    {

        if (!Gate::any(['isAdmin', 'isOwner'])) {
            return abort(403, 'شما به این بخش دسترسی ندارید.');
        }

        $newcity = new City;
        $newcity->name = $request->input('city_subject');
        $newcity->state_id = $request->input('state_id');

        $newcity->save();

        return;
    }

    public function adm_user()
    {

        $users = User::all();
        $roles = collect(
            [
                ['name' => 'admin',
                    'role' => 'ادمین'],
                ['name' => 'editor',
                    'role' => 'بلاگ نویس'],
                ['name' => 'issuer',
                    'role' => 'تایید آگهی'],
                ['name' => 'user',
                    'role' => 'عدم دسترسی'],
            ]
        );


        return view('admin.adm_user', compact('users', 'roles'));
    }

    public function add_new_user(Request $request)
    {
        $password = $request->user_password;
        if ($request->user_password == "")
            $password = rand(11111111, 99999999);

        $user = User::create([
            'name' => $request->user_name,
            'email' => $request->user_email,
            'password' => Hash::make($request->user_password),
        ]);
        UserPermission::create([
            'user_id' => $user->id,
            'role' => $request->user_role
        ]);

        return response()->json(['status' => true, 'name' => $request->user_email, 'password' => $password]);


    }

    public function adm_showuser($id)
    {

        $showuser = User::find($id);
        $roles = ['admin', 'editor', 'issuer'];

        $data = array(
            'showuser' => $showuser,
            'roles' => $roles
        );


        return view('admin.adm_showuser', $data);
    }

    public function update_user(Request $request, $id)
    {

        $this->validate(
            $request,
            ['newusername' => 'required',
                'newemail' => 'required',
                'newpassword' => 'required',],

            ['newusername.required' => 'یوزرنیم الزامی می باشد.',
                'newemail.required' => 'ایمیل الزامی می باشد.',
                'newpassword.required' => 'وارد کردن پسورد الزامی می باشد.']


        );

        $user = User::find($id);

        $user->name = $request->input('newusername');
        $user->email = $request->input('newemail');
        $user->password = Hash::make($request->input('newpassword'));
        $user->save();


        if (count($user->userpermissions) == 1) {
            $role = UserPermission::find($user->userpermissions);
            $role[0]->role = $request->role;
            $role[0]->save();
        } else {
            $role = new UserPermission;
            $role->user_id = $id;
            $role->role = $request->role;
            $role->save();
        }


        return back()->with('success', 'کاربر مورد نظر با موفقیت ویرایش گردید');
    }

    private function isUserAdmin()
    {
        $user = Auth::user();

        if ($user->access_admins != 1) {
            Auth::logout();
            return redirect('/login');
        }
    }

    public function index_tech_checkup()
    {
        $techs = TechCheckUp::all();
        $states = State::all();
//        $cities = City::all()->sortBy('name');
        return view('admin.add_tech_checkUp', compact('techs', 'states'));
    }

    public function add_tech_checkup(Request $request)
    {

        TechCheckUp::create([
            'name' => $request->name,
            'address' => $request->address,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'tel' => $request->tel,
        ]);
        return back();
    }

    public function types()
    {
        $types = Type::all();
        return view('admin.vehicle_types', compact('types'));
    }

    public function adm_received_message()
    {
        $chats = Chat::all()->where('user_id' , '!=' , 0)
                            ->sortBydesc('created_at')
                            ->groupBy('user_id');
        


        return view('admin.adm_received_message' , compact('chats'));
        
    }
    
    public function get_message(Request $request){
        
        $chats = Chat::where('user_id' , $request->id)->orderBy('created_at' , 'asc')->get();
        $id = $request->id;
        return view('admin.message_content' , compact('chats' , 'id'));
        
        // return response(['data' => $chats]);
        
    }
    
    public function send_response_chat(Request $request){
        
        $chat = new Chat();
        $chat->user_id = $request->id;
        $chat->reply = 1;
        $chat->content = $request->res;
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

        $data = ['userId' => $request->id , 'from_user' => 0 , 'content' => $request->res]; 
        $pusher->trigger('message_channel' , 'message_event' , $data);
        
        $time = \Morilog\Jalali\Jalalian::now()->addHours(3)->addMinutes(30)->format('H:i - %B %d');
        
        return response(['success' => true , 'time' => $time]);
        
        
    }

    public function send_response_message(Request $request)
    {
        $message = ContactUs::find($request->id);
        $message->response = $request->response;
        $message->save();
        return response()->json(['success' => true]);
    }
    
    private function store_img($file){
            
        $img = \Intervention\Image\Facades\Image::make($file);
            
        $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
        $img->resize(300, 300);
        $img->insert($watermark, 'bottom-left', 5, 5);
        $fileNameToStore = time() . $file->getClientOriginalName();
            
        $success = $img->save('advertise/' . $fileNameToStore);
        
        return $fileNameToStore;
    }

    public function advertise_lux()
    {
        $luxes = Lux::all();
        $states = State::all()->sortBy('name');
        return view('admin.advertise.lux', compact('luxes', 'states'));
    }

    public function add_advertise_lux(Request $request)
    {
        if ($request->hasFile('main_img')) {

            $fileNameToStore = $this->store_img($request->file('main_img'));

        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        $lux = $request->all();
        $lux['main_img'] = $fileNameToStore;
        
        Lux::create($lux);
        
        return back();

    }


    public function advertise_accessory()
    {

        $accesses = Accessory::all();
        $states = State::all()->sortBy('name');
        return view('admin.advertise.accessory', compact('accesses', 'states'));
    }

    public function add_advertise_accessory(Request $request)
    {
        if ($request->hasFile('main_img')) {

            $fileNameToStore = $this->store_img($request->file('main_img'));

        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        $access = $request->all();
        $access['main_img'] = $fileNameToStore;
        
        Accessory::create($access);
        
        return back();
    }
    
    public function add_advertise_insurance(Request $request)
    {

        if ($request->hasFile('main_img')) {

            $fileNameToStore = $this->store_img($request->file('main_img'));

        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        $ins = $request->all();
        $ins['main_img'] = $fileNameToStore;
        
        Insurance::create($ins);
        
        return back();        

    }
    
    public function advertise_insurance()
    {
        $insurances = Insurance::all();
        $states = State::all()->sortBy('name');
        return view('admin.advertise.insurance', compact('insurances', 'states'));
    }


    // public function delete_post($id)
    // {
    //     $post = Post::find($id);
    //     $post->is_delete = 1;
    //     $post->is_active = 0;
    //     $post->save();
    //     return back();
    // }
    
        public function delete_post(Request $request)
    {
        $post = Post::find($request->id);
        $post->is_delete = 1;
        $post->is_active = 0;
        $post->save();
        return response()->json(['status' => true]);
    }
    

    public function re_active_post($id)
    {
        $post = Post::find($id);
        $post->is_delete = 0;
        $post->is_active = 0;
        $post->save();
        return back();
    }
    
    public function adm_offer_message()
    {
        
        $messages = ContactUs::all();
        foreach($messages as $m){
            $m->checked = 1;
            $m->save();
        }
        
        $messages = $messages->sortByDesc('created_at');
        \session()->put('new_msg', []);
        
        return view('admin.adm_offer_message' , compact('messages'));
    }

    public function report_problem()
    {
        
        $messages = ContactUs::all();

        return view('admin.adm_offer_message' , compact('messages'));
    }  
    
    public function payments()
    {
        $payments = PostExtras::all()->groupBy(['post_id' , 'payment'])->reverse();
        $pays = Payment::where('checked' , 0)->get();
        foreach($pays as $pay){
            $pay->checked = 1;
            $pay->save();
        }
        \session()->put('new_pay', []);
    
        return view('admin.posts.payments' , ['payments' => $payments]);
    }
    
    
    public function clear_payment(Request $request)
    {
        $pays = Payment::where('checked' , 0)->get();
        foreach($pays as $pay){
            $pay->checked = 1;
            $pay->save();
        }
        \session()->put('new_pay', []);
    
        return true;
    }    

}
