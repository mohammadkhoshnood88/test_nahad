<?php

namespace App\Http\Controllers;

use App\Models\Cbrand;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use App\Models\Post;
use App\Models\Image;
use App\Models\VehicleMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap;
use Carbon\Carbon;
use Spatie\Sitemap\Tags\Url;



class AdminPermissionsController extends Controller
{
    public function index()
    {
        // $images = Image::where('post_id' , 2827)->get();
    
        
        // foreach($images as $image){

        // $img = \Intervention\Image\Facades\Image::make('post_images/related_images/' . $image->path);
        // $watermark = \Intervention\Image\Facades\Image::make('post_images/logo.png');
        // $img->fit(300, 300);
        // $img->orientate();
        // $img->insert($watermark, 'bottom-left', 5, 5);
        
        // $success = $img->save('post_images/related_images_watermark/' . $image->path);
        
        // }
        return "ok";

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
                     ->add(Url::create('https://18charkh.com/userpanel/message')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1))
                     ->add(Url::create('https://18charkh.com/userpanel/message')->setLastModificationDate($date)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1));
                        
                        foreach($posts as $post){
                            $id = $post->id;
                            $subject = str_replace([' ' , '/'], '_', $post->subject);
                            
                     $sitemap->add(Url::create("https://18charkh.com/advertises/show/$id/$subject")->setLastModificationDate(Carbon::parse($post->created_at))->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(0.8));

                        }


    $sitemap->writeToFile('sitemap.xml');        
        
        return;
        

        SitemapGenerator::create('https://18charkh.com/')->writeToFile('testsitemap.xml');

        return "sdfas";
        $users = User::all();
        return view('admin.permissions' , compact('users'));
    }

    public function json()
    {
//        $aaaa = Storage::get('convertcsv.json');
//        $aaa =  json_decode($aaaa);

        return "sdfasdf";

        ini_set('max_execution_time', 300);
        $a =
"[
 {
   \"A\": \"????????????????\",
   \"B\": \"az\"
 },
 {
   \"A\": \"??????????\",
   \"B\": \"amico\"
 },
 {
   \"A\": \"?????????? ?????????? ????????\",
   \"B\": \"iran\"
 },
 {
   \"A\": \"???????? ????????\",
   \"B\": \"bahman\"
 },
 {
   \"A\": \"?????????? ???????? (BMC)\",
   \"B\": \"bmc\"
 },
 {
   \"A\": \"???????????????????? ?????????? ??????????????????\",
   \"B\": \"\"
 },
 {
   \"A\": \"?????????? ???????? ??????????\",
   \"B\": \"jmc\"
 },
 {
   \"A\": \"????????????\",
   \"B\": \"zamyad\"
 },
 {
   \"A\": \"?????????? ????????\",
   \"B\": \"saypa disele\"
 },
 {
   \"A\": \"???????? ???????? ???????? (Hyundai)\",
   \"B\": \"sepehr\"
 },
 {
   \"A\": \"?????????????? ??????????(KAVIAN)\",
   \"B\": \"kaviran\"
 },
 {
   \"A\": \"?????????? ????????\",
   \"B\": \"mamut\"
 },
 {
   \"A\": \"CAT\",
   \"B\": \"cat\"
 },
 {
   \"A\": \"??????????????\",
   \"B\": \"scania\"
 },
 {
   \"A\": \"????????????\",
   \"B\": \"iveco\"
 },
 {
   \"A\": \"??????\",
   \"B\": \"benz\"
 },
 {
   \"A\": \"??????\",
   \"B\": \"daf\"
 },
 {
   \"A\": \"??????\",
   \"B\": \"renault\"
 },
 {
   \"A\": \"??????\",
   \"B\": \"man\"
 },
 {
   \"A\": \"????????\",
   \"B\": \"volvo\"
 },
 {
   \"A\": \"???? ????\",
   \"B\": \"ud\"
 }
]";
//            $a = str_replace(" " , ',' , $a);
//            return $a;
//            $aa = explode(',' , $a);
//            foreach ($aa as $av){
//                $meta = new VehicleMeta();
//                $meta->type_id = '4';
//                $meta->key = "tonnage";
//                $meta->value = $av;
//                $meta->save();
//            }


//        $aa = str_replace(':' , '=>' , $a);
//        $aaa = str_replace('{' , '[' , $aa);
//        $aaaa = str_replace('}' , ']' , $aaa);
//        $png = ".png";
////        return $aaaa;
//
//        $aaaa = [ [ "A"=> "????????????????", "B"=> "az" ], [ "A"=> "??????????", "B"=> "amico" ], [ "A"=> "?????????? ?????????? ????????", "B"=> "iran" ], [ "A"=> "???????? ????????", "B"=> "bahman" ], [ "A"=> "?????????? ???????? (BMC)", "B"=> "bmc" ], [ "A"=> "???????????????????? ?????????? ??????????????????", "B"=> "" ], [ "A"=> "?????????? ???????? ??????????", "B"=> "jmc" ], [ "A"=> "????????????", "B"=> "zamyad" ], [ "A"=> "?????????? ????????", "B"=> "saypa disele" ], [ "A"=> "???????? ???????? ???????? (Hyundai)", "B"=> "sepehr" ], [ "A"=> "?????????????? ??????????(KAVIAN)", "B"=> "kaviran" ], [ "A"=> "?????????? ????????", "B"=> "mamut" ], [ "A"=> "CAT", "B"=> "cat" ], [ "A"=> "??????????????", "B"=> "scania" ], [ "A"=> "????????????", "B"=> "iveco" ], [ "A"=> "??????", "B"=> "benz" ], [ "A"=> "??????", "B"=> "daf" ], [ "A"=> "??????", "B"=> "renault" ], [ "A"=> "??????", "B"=> "man" ], [ "A"=> "????????", "B"=> "volvo" ], [ "A"=> "???? ????", "B"=> "ud" ] ] ;
//
//        foreach ($aaaa as $aaa){
//            $brand = new Cbrand();
//            $brand->name = $aaa['A'];
//            $brand->img_path = $aaa['B'] .$png;
//            $brand->save();
//        }
//        return "ok";


//        $states = State::all();
////        return $states[0]->name;
//        foreach ($states as $state)
//        {
//            foreach ($aaaa as $city)
//            {
//                if ($state->name == $city['A'])
//                {
//                    $c = new City();
//                    $c->name = $city['B'];
//                    $c->state_id = $state->id;
//                    $c->save();
//
//                }
//            }
//        }
    }
}
