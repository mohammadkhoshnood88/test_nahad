<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cbody;
use App\Models\Cbrand;
use App\Models\City;
use App\Models\Cmodel;
use App\Models\Color;
use App\Models\ContactUs;
use App\Models\Image;
use App\Models\MarkPost;
use App\Models\Post;
use App\Models\State;
use App\Models\PostExtras;
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
use App\Models\Lux;
use Zarinpal\Zarinpal;


class CustomerFinancialController extends Controller
{

    public $loginAfterSignUp = true;


    public function __construct()
    {
        auth()->setDefaultDriver('api');
    }    
    
    public function cart(Request $request){
        
        $user = auth()->user();
        $post = Post::where('id' , $request->post_id)->where('phone_number' , $user->phone_num)->get();
        
        if(count($post) == 0){
            return response()->json(['success' => false , 'message' => 'این آگهی متعلق به شما نیست']);
        }
        
        $post_options = PostExtras::where('post_id' , $request->post_id)->where('payment' , 0)->get();
        
        $items = [
            'ladder' => [
                "name" => "نردبان",
                "price" => 15000
                ],
            'urgent' => [
                "name" => "فوری",
                "price" => 25000
                ],
            'special' => [
                "name" => "ویژه",
                "price" => 46000
                ],
            're_active' => [
                "name" => "تمدید",
                "price" => 0
                ],                
            ];
        
        return response()->json(['success' => true , 'items' => $items , 'post_option' => $post_options]);
    
    }
    
    public function store_upgrade(Request $request){
        
        $user = auth()->user();
    
        $post = Post::where('id' , $request->post_id)->where('phone_number' , $user->phone_num)->get();
        
        if(count($post) == 0){
            return response()->json(['success' => false , 'message' => 'این آگهی متعلق به شما نیست']);
        }
        
        
        $oldex = PostExtras::where('post_id' , $request->post_id)->get();

        $options = ['ladder' , 'urgent' , 'special' , 're_active'];

        foreach ($options as $option){

            if ($request[$option] == 1){
                $old = $oldex->where('option_name' , '=' , $option);
                $dont_pay = $old->where('payment' , '=' , 0)->count();
                $paid = $old->where('payment' , '!=' , 0)->count();

                if ($dont_pay == 0)
                    $this->set_option($option , $paid + 1 , $request->post_id);
            }

        }
        
        $p = false;
        if($request->payment)
            $p = $this->response_pay($request->post_id , $Authority);
        
        
        return response()->json(['success' => true , 'payment' => $p  , 'message' => 'فاکتور شما آماده پرداخت است']);
        
    }
    
    private function set_option($option , $id , $post_id)
    {
        $user = auth()->user();

        $post_extras = new PostExtras();
        $post_extras->user_id = $user->id;
        $post_extras->post_id = $post_id;
        $post_extras->option_name = $option;
        $post_extras->option_id = $id;
        $post_extras->payment = 0;
        $post_extras->save();
        
        if($post_extras->save())
            return true;
        return false;

    }
    
    public function invoice(Request $request){

        $user_id = auth()->id();
        
        $carts = PostExtras::where('user_id' , '=' , $user_id)
                            ->where('post_id' , '=' , $request->post_id)
                            ->where('payment' , '=' , 0)
                            ->get();
        
    
        if(count($carts) == 0)
            return response()->json(['success' => false , 'message' => 'فاکتور وجود ندارد']);
        
        return response()->json(['success' => true , 'data' => $carts]);
    }
    

    public function request_pay(Request $request)
    {

        $user = auth()->user();

        $post = Post::where('id' , $request->post_id)->where('phone_number' , $user->phone_num)->get();
        
        if(count($post) == 0){
            return response()->json(['success' => false , 'message' => 'این آگهی متعلق به شما نیست']);
        }

        $pay = PostExtras::where('user_id' , '=' , $user->id)
                            ->where('post_id' , '=' , $request->post_id)
                            ->where('payment' , '=' , 0)
                            ->get();
                            
        if(count($pay) == 0){
            return response()->json(['success' => false , 'message' => 'صورت حسابی ثبت نشده است']);
        }                            


        $total_price = 0;
        
        
        foreach ($pay as $p){
            $total_price = $total_price + option_price($p->option_name , $p->option_id);
        }
        
        $total_price = $total_price * 1000;

        $zarinpal = new Zarinpal('78253174-2cfc-4889-84fa-b47962db4cb6');

        $zarinpal->isZarinGate();

        $id = $post[0]->id;
        
        $results = $zarinpal->request(
            "https://18charkh.com/api/v1/financial/response_pay/$id",
            $total_price,"desc", "emali@gmail.com", $user->phone_num);

        if (isset($results['Authority'])) {
            file_put_contents('Authority', $results['Authority']);
            $a = $results['Authority'];
            return redirect("https://www.zarinpal.com/pg/StartPay/$a/zaringate");

            $zarinpal->redirect();

        }
    }


    public function response_pay($id , $Authority)
    {
        $MerchantID = '78253174-2cfc-4889-84fa-b47962db4cb6';

        $user_id = auth()->id();

        $Amount = 0;
        $pay = PostExtras::where('post_id' , '=' , $id)->where('user_id' , '=' , $user_id)
            ->where('payment' , '=' , 0)->get();

        $post = Post::where('id', '=', $id)->first();

        
        foreach ($pay as $p){
            $Amount = $Amount + option_price($p->option_name , $p->option_id);
        }

        $Amount = $Amount * 1000;
        // $Amount = 1000;


        //ما در اینجا مبلغ مورد نظر را بصورت دستی نوشتیم اما در پروژه های واقعی باید از دیتابیس بخوانیم
//        $Amount = $total_price;
        if (\request()->get('Status') == 'OK') {

            $option_id = [];

            $client = new \nusoap_client('https://www.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
            $client->soap_defencoding = 'UTF-8';

            //در خط زیر یک درخواست به زرین پال ارسال می کنیم تا از صحت پرداخت کاربر مطمئن شویم
            $result = $client->call('PaymentVerification', [
                [
                    //این مقادیر را به سایت زرین پال برای دریافت تاییدیه نهایی ارسال می کنیم
                    'MerchantID' => $MerchantID,
                    'Authority' => $Authority,
                    'Amount' => $Amount,
                ],
            ]);

            $result['Status'] = 100;
            $idd = $id;
            if ($result['Status'] == 100) {

                $new_amount = new Payment();
                $new_amount->post_id = $id;
                $transaction = rand(10000000, 99999999);
                $new_amount->transaction_number = $transaction;
                $new_amount->amount = $Amount;
                $new_amount->save();
                
                foreach ($pay as $p){

      
                    $a = false;

                    if ($p->option_name == "ladder"){
                        $a = $this->ladder($id , $post);
                    }                    
                    if ($p->option_name == "instagram"){
                        $a = $this->instagram($id , $post);
                    }
                    if ($p->option_name == "website"){
                        $a = $this->website($id , $post);
                    }
                    
                    if ($p->option_name == "urgent"){
                        $a = $this->urgent($id , $post);
                    }
                    
                    if ($p->option_name == "special"){
                        $a = $this->vip($id , $post);
                    }
                    
                    if ($p->option_name == "re_active"){
                        $a = $this->re_active($id , $post);
                    }
                    // dump($a);
                    if ($a){
                        $p->payment = $new_amount->id;
                        $p->post_id = $id;
                        $p->save();
                   
                    }
                }

                return true;

            } else {
                return false;
            }
        } else {
                return false;
        }


    }
    
    public function vip($id , $post)
    {

        $vip = new VipPost();
        $vip->post_id = $id;
        $vip->save();
        return true;

    }

    public function urgent($id , $post)
    {
        $post->urgent = 1;
        $post->save();
        return true;

    }

    public function ladder($id , $post)
    {
        $post->sort_id = Carbon::now()->addHours(3)->addMinutes(30);
        // timezone taghir nakard az haminja taghir dadam
        $post->save();

        $ladder_post = new LadderPost();
        $ladder_post->post_id = $post->id;
        $ladder_post->save();
        
        return true;
    }
    
    private function just_re_active($id){
        
        $user_id = auth()->id();
        dump($id);
        $post = Post::where('id', '=', $id)->first();
        
        $new_amount = new Payment();
        $new_amount->post_id = $id;
        $transaction = rand(10000000, 99999999);
        $new_amount->transaction_number = $transaction;
        $new_amount->amount = 0;
        $new_amount->save();
        
        \session()->flash('factor_price' , 'رایگان');
        $a = $this->re_active($id , $post);
        if($a){
            
            $pay = PostExtras::where('post_id' , '=' , $id)->where('user_id' , '=' , $user_id)
            ->where('payment' , '=' , 0)->first();
            
            $pay->payment = $new_amount->id;
            $pay->post_id = $id;
            $pay->save();
            
            \session()->put('pay_key' , 'valid');
            \session()->flash('transaction' , $transaction);
            return redirect("userpanel/financial/post/$id/factor");
        
            } else {
            
            \session()->flash('transaction' , "");
            return redirect("userpanel/financial/post/$id/factor");
                
            }
        
    }
    

    public function re_active($id , $post)
    {
        
        if($post->confirm_at != null && $post->own_delete == 0 && $post->is_delete == 1){
        
        $ex = Carbon::now()->addMonth();
        $now = Carbon::now();
        $post->is_active = 1;
        $post->is_delete = 0;
        $post->expire_at = $ex;
        $post->sort_id = $now;
        $post->save();
        return true;
            
        }
        return false;


    }
    
    public function instagram($id , $post)
    {
        $bind = [
            'id' => $id
        ];

        $insta = DB::select("
            select instagram_id
            from instagram_ids
            where post_id = :id
          " , $bind);

        $post->instagram_id = $insta[0]->instagram_id;
        $post->save();

        return true;

    }

    public function website($id , $post)
    {
        $bind = [
            'id' => $id
        ];

        $web = DB::select("
            select website
            from web_sites
            where post_id = :id
          " , $bind);

        $post->website = $web[0]->website;
        $post->save();

        return true;

    }
    
    public function remove_cart(Request $request)
    {
        $option = PostExtras::all()->where('id' , '=' , $request->id)->first();

        $option->delete();

        return response()->json(['success' => true]);
    }
    
    
}
