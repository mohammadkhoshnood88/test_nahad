<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\InstagramId;
use App\Models\WebSite;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Pusher\Pusher;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function posts(Request $request){
        
        $now = Carbon::now()->addHours(3)->addMinutes(30)->subDays(2);
        
        $vip_posts = DB::table('posts as p')->join('vip_posts as vp' , 'p.id' , '=' , 'vp.post_id')
        ->where('vp.created_at' , '>=' , $now)->orderBy('p.sort_id' , 'desc')->take(10)->get();
        
        $posts = DB::table('posts')->where('is_active', 1)->where('is_rent' , $request->is_rent)
        ->orderBy('sort_id' , 'desc')
        ->select(['id', 'color_id', 'subject', 'cbrand_id', 'type', 'image_path', 'is_rent', 'driver_status' , 'price' , 'trending'])
        ->get()->groupBy('type');
        
        foreach($posts as $key=>$post)
        {
            $posts[$key] = $posts[$key]->take(10);

        }
        $p = [];
        foreach($posts as $key=>$post)
        {
            array_push($p , array('list' => array('item' => $key , 'list' => $posts[$key])));
    
        }
        
        array_push($p , array('list' => array('item' => 0 , 'list' => $vip_posts)));
    
        
        
        return response()->json(['success' => true , 'posts' => $p]);
    }
    
    public function store_post(Request $request)
    {
        $post = Post::create($request->all());

        $post->sort_id = Carbon::now();
        
        // if (isset($request->images[0]['image_name']))
        //     $post->image_path = $request->images[0]['image_name'];
        // else
        //     $post->image_path = 'noimage.jpg';
            
        
        if (isset($request->images[0]))
            $post->image_path = $request->images[0];
        else
            $post->image_path = 'noimage.jpg';
        
            
        $post->save();
        
        if (isset($request->images[0])){

            foreach ($request->images as $image) {

                $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $image);
                $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
                $img->fit(300, 300);
                $img->insert($watermark, 'bottom-left', 5, 5);

                $img->fit(300, 300);

                $success = $img->save('post_images/related_images_watermark/' . $image);

                $new_image = new Image;
                $new_image->post_id = $post->id;
                $new_image->path = $image;
                $new_image->save();

            }

        }else{

            $new_image = new Image;
            $new_image->post_id = $post->id;
            $new_image->path = "noimage.jpg";
            $new_image->save();

        }
        
        $payment = false;
        $pay_options = [];
        if (isset($request->instagram_id)){
            $new_option = Financial::getInstance();
            $new_option->AddPostExtras(auth()->id() , $post->id , 'instagram');
            $insta = new InstagramId();
            $insta-> instagram_id = $request->instagram_id;
            $insta->post_id = $post->id;
            $insta->save();
            
            array_push($pay_options , 'instagram');
            
            $payment = true;
        }
        
        if (isset($request->website)){
            $new_option = Financial::getInstance();
            $new_option->AddPostExtras(auth()->id() , $post->id , 'website');
            $insta = new WebSite();
            $insta->website = $request->website;
            $insta->post_id = $post->id;
            $insta->save();
            
            array_push($pay_options , 'website');
        
            $payment = true;            
        }
        
        $pay = false;
        if($payment && $request->payment)
            $pay = $this->payment($post , $post->id , $pay_options , $request->Authority);
        


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

        $data = ['id' => $post->id,
            'image' => $post->image_path ,
            'brand' => $post->cbrand->name ,
            'subject' => $post->subject ,
            'mobile' => $post->phone_number,
            'is_rent' => $post->is_rent];

        $pusher->trigger('new_post_channel' , 'new_post_event' , $data);
        
        return response()->json(['success' => true, 'payment' => $pay , 'message' => 'آگهی شما ثبت شد و بعد از تایید کارشناسان 18چرخ به نمایش درخواهد آمد']);

    }
    
    
        public function payment($post , $post_id , $payments , $Authority)
    {
        $MerchantID = '78253174-2cfc-4889-84fa-b47962db4cb6';

        $user_id = auth()->id();

        $Amount = 0;

        foreach ($payments as $p){
            $Amount = $Amount + option_price($p , 0);
        }

        $Amount = $Amount * 1000;

        if (\request()->get('Status') == 'OK') {

            $option_id = [];

            $client = new \nusoap_client('https://www.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
            $client->soap_defencoding = 'UTF-8';

            $result = $client->call('PaymentVerification', [
                [
                    'MerchantID' => $MerchantID,
                    'Authority' => $Authority,
                    'Amount' => $Amount,
                ],
            ]);

            $result['Status'] = 100;
            $idd = $id;
            if ($result['Status'] == 100) {

                $new_amount = new Payment();
                $new_amount->post_id = $post_id;
                $transaction = rand(10000000, 99999999);
                $new_amount->transaction_number = $transaction;
                $new_amount->amount = $Amount;
                $new_amount->save();
                

                foreach ($payments as $p){

      
                    $a = false;

                    if ($p == "ladder"){
                        $a = $this->ladder($id , $post);
                    }                    
                    if ($p == "instagram"){
                        $a = $this->instagram($id , $post);
                    }
                    if ($p == "website"){
                        $a = $this->website($id , $post);
                    }
                    
                    if ($p == "urgent"){
                        $a = $this->urgent($id , $post);
                    }
                    
                    if ($p == "special"){
                        $a = $this->vip($id , $post);
                    }
                    
                    if ($p == "re_active"){
                        $a = $this->re_active($id , $post);
                    }

                    if ($a){
                        $p->payment = $new_amount->id;
                        $p->post_id = $post_id;
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

    
}
