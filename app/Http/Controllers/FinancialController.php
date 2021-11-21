<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\LadderPost;
use App\Models\Payment;
use App\Models\Post;
use App\Models\PostExtras;
use App\Models\VipPost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Zarinpal\Zarinpal;

class FinancialController extends Controller
{
        private $Authority = "";


    public function factor($id){

        if (\session()->get('pay_key') != 'valid') {
            Session::forget('pay_key');
            return redirect('userpanel/myadvertises');
        }
        $transaction = \session()->get('transaction');

        $bind = ["id" => $id];
        $post = DB::select("
            select phone_number , subject
            from posts
            where id = :id
        " , $bind);
        
        if($transaction != ""){
            $price = \session()->get('factor_price');
            $message = "فاکتور شما به شماره $transaction با موفقیت در سامانه 18 چرخ پرداخت شد.";
            $sms = new Sms();
            $sms->factor($post[0]->phone_number , $message);
            
        }


        return view('financial.factor' , compact('post' , 'transaction'));
    }
        
    public function cart($id){
        
        
        $mobile = session()->get('phone_number');
        
        if(empty($mobile))
            return redirect('userpanel/myadvertises');

        $user_id = $this->user();
        
        $bind = [
            'id' => $id,
            'mobile' => $mobile
        ];
        $post = DB::select('
        select id
        from posts
        where id = :id AND phone_number = :mobile ' , $bind);
        if(count($post) == 0)
            return abort(404);
        
        
        // $cart = PostExtras::all()->where('user_id' , '=' , $user_id);
        $cart = PostExtras::where('user_id' , '=' , $user_id);
        
        
        $cart = $cart->where('post_id' , '=' , $id)->where('payment' , '=' , 0)->get();
        
        if(count($cart) == 0)
            return back();
        
        $in = ["instagram" , "website"];
        $out = ["urgent" , "special" , "ladder" , "re_active"];
        $inside = $cart->whereIn('option_name' , $in);
        $outside = $cart->whereIn('option_name' , $out);


        return view('financial.cart' , compact('cart' , 'inside' , 'outside' , 'id'));
    }
    
    public function upgrade($id)
    {

        $mobile = session()->get('phone_number');
        
        if(empty($mobile))
            return redirect('userpanel/myadvertises'); 
        
        $user_id = $this->user();
        
        
        // return $mobile;
        $bind = [
            'id' => $id,
            'mobile' => $mobile
        ];
        $post = DB::select('
        select id , is_active , own_delete , expire_at
        from posts
        where id = :id AND phone_number = :mobile ' , $bind);

        if(count($post) == 0)
            return abort(404);
            
        $is_active = $post[0]->is_active;
        $own_delete = Carbon::parse($post[0]->own_delete)->toDateString();
        $expire_at = Carbon::parse($post[0]->expire_at)->toDateString();

        // $now = Carbon::now();
        // $now = $now->toDateString();
        
        // $a = Carbon::parse($expire_at)->diffInDays($now) == 1 && Carbon::parse($expire_at)->gt($now);

        // $extras = PostExtras::where('post_id' , '=' , $id)->get([ 'payment' ,'option_id'])->keyBy('option_name')->toArray();
        $extras = PostExtras::all()->where('post_id' , '=' , $id)->pluck('payment' , 'option_name')->toArray();
        
        $post_id = $id;
        
        return view('userpanel.upgrade' , compact('extras' , 'post_id' , 'is_active' , 'own_delete' , 'expire_at'));
    }
    

    public function request_pay(Request $request)
    {
        
        $mobile = session()->get('phone_number');
        
        if(empty($mobile))
            return redirect('userpanel/myadvertises');

        $user_id = $this->user();
        
//        $mobile = '09368816042';
        $bind = [
            'id' => $request->id,
            'mobile' => $mobile
        ];
        $post = DB::select('
        select id
        from posts
        where id = :id AND phone_number = :mobile ' , $bind);


        if(count($post) == 0)
            return abort(404);

        $total_price = 0;

        $bind = [
            'id' => $request->id,
            'user_id' => $user_id
        ];
        $pay = DB::select('
        select option_name , option_id
        from post_extras
        where post_id = :id AND user_id = :user_id AND payment = 0 ' , $bind);
        
        
        if(count($pay) == 1 && $pay[0]->option_name == 're_active'){
            return $this->just_re_active($request->id);
             
        }
        
        
        if(count($pay) == 0)
            return redirect('userpanel/myadvertises');
        
        // if(count($pay) == 1 && $pay[0]->option_name == 're_active'){
        //             $a = false;
        //             $post = Post::where('id', '=', $id)->first();
             
        //             $a = $this->re_active($request->id , $post);
                    
        //             if ($a){
        //                 $p->payment = $new_amount->id;
        //                 $p->post_id = $id;
        //                 $p->save();
                   
        //             }
            
        // }
        
        
        foreach ($pay as $p){
            $total_price = $total_price + option_price($p->option_name , $p->option_id);
        }
        

        $total_price = $total_price * 1000;


        // $zarinpal = new Zarinpal('892fd30e-e4f8-11e5-ad19-000c295eb8fc');
        $zarinpal = new Zarinpal('78253174-2cfc-4889-84fa-b47962db4cb6');

        $zarinpal->isZarinGate();

        $id = $post[0]->id;
        // $total_price = 1000;

        $results = $zarinpal->request(
            "https://18charkh.com/userpanel/financial/response_pay/$id",
            $total_price,"desc", "emali@gmail.com", $mobile);

        if (isset($results['Authority'])) {
            file_put_contents('Authority', $results['Authority']);
            $a = $results['Authority'];
            return redirect("https://www.zarinpal.com/pg/StartPay/$a/zaringate");

            $zarinpal->redirect();

        }
    }


    public function response_pay($id)
    {
        $MerchantID = '78253174-2cfc-4889-84fa-b47962db4cb6';
        $Authority = \request()->get('Authority');

        $user_id = $this->user();

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
                
                \session()->flash('factor_price' , $Amount);


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

                    if ($a){
                        $p->payment = $new_amount->id;
                        $p->post_id = $id;
                        $p->save();
                   
                    }
                }

                \session()->put('pay_key' , 'valid');
                \session()->flash('transaction' , $transaction);

                return redirect("userpanel/financial/post/$idd/factor");

            } else {
                \session()->put('pay_key' , 'unvalid');
                \session()->flash('transaction' , "");
                return redirect("userpanel/financial/post/$idd/factor");
            }
        } else {
            \session()->put('pay_key' , 'unvalid');
            \session()->flash('transaction' , "");
            return redirect("userpanel/financial/post/$id/factor");
        }


    }


    public function verify($amount, $authority, $m)
    {
        // backward compatibility
        if (count(func_get_args()) == 4) {
            $amount = func_get_arg(1);
            $authority = func_get_arg(2);
            $m = func_get_arg(3);
        }

        $inputs = [
            'MerchantID' => $m,
            'Authority' => $authority,
            'Amount' => $amount,
        ];

//        return $inputs;
        return $driver->verifyWithExtra($inputs);
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
        
        $user_id = $this->user();
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

    private function user()
    {
        $mobile = session()->get('phone_number');
        if(empty($mobile)){
            return 0;
        }

        $bind = [
            'mobile' => $mobile
        ];
        $user_id = DB::select("
        select id
        from user_panels
        where phone_num = :mobile
        " , $bind);

        return $user_id[0]->id;
    }
}
