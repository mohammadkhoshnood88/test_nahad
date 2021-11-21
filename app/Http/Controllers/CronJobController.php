<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;


class CronJobController extends Controller
{
    public function check_expire_time()
    {

        // $posts = Post::all()
        //     ->where('is_active', '=', 1)
        //     ->where('is_delete', '=', 0)
        //     ->where('own_delete' , '=' , 0);

        // $now = Carbon::now();
        // $now = $now->toDateString();

        // foreach ($posts as $p) {
        //     $ex = Carbon::parse($p->expire_at)->toDateString();
        //     if (Carbon::parse($ex)->diffInDays($now) == 1 && Carbon::parse($ex)->gt($now)) {

        //         $sms = new Sms();
        //         $mobile = $p->phone_number;
        //         $title = $p->subject;
        //         $title = mb_substr($title , 0 , 8 , 'utf-8');
        //         $title = $title . "...";
        //         $title = str_replace(" " , "-" , $title);
        //         $l = $p->shortlink;

        //         $link = "18charkh.com/RA/$l";
        //         $sms->expire($mobile, $title , $link);

        //     }
            
        //     if ($ex === $now) {
        //         // dump($p->id);
        //         $p->is_active = 0;
        //         $p->is_delete = 1;
        //         $p->save();
                
        //     }

        // }
        
        $a = 5;

    }
    
    public function create_sitemap(){
         
    Log::info("+++++++++++++++++++++++++++++++++++++++++++++++");
    $posts = Post::all();
    $date = Carbon::create(2020, 7, 5, 0, 0, 0);
    
    $sitemap = Sitemap::create()->add(Url::create('https://18charkh.com')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/advertises/create')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/rent/create')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/advertises/all')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/rent/all')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/insurance')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/accessory')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/lux')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/blog')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/rules')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/contact')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/about')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/userpanel/myadvertises')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/userpanel/markadvertises')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/userpanel/offer')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/userpanel/message')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1));

                    foreach($posts as $post){
                            $id = $post->id;
                            $subject = str_replace([' ' , '/'], '_', $post->subject);
                            
                            $sitemap->add(Url::create("https://18charkh.com/advertises/show/$id/$subject")->setLastModificationDate(Carbon::parse($post->created_at))->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(0.8));

                        }

    
    $sitemap->writeToFile('sitemap.xml');
    
    Log::info("cron run");
    Log::info("+++++++++++++++++++++++++++++++++++++++++++++++");
    
    return;

        
        
    }


}
