<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\ContactUs;
use App\Models\Insurance;
use App\Models\Lux;
use App\Models\Post;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Morilog\Jalali\Jalalian;
use App\Models\Image;


class HomeController extends Controller
{
    public function index()
    {
        $contact = Cache::get('contact' , function (){
            return ContactUs::all()->where('point' , '=' , 5)->take(4);
        });

        // $contact = ContactUs::all()->where('point' , '=' , 5)->take(4);
        // return $contact;
        
        return view('pages.index' , compact('contact'));
    }
    public function contact()
    {

        return view('pages.contact');
    }

    public function store_contact_us(Request $request)
    {
        $message = new ContactUs();
        $message->subject = $request->title;
        $message->content = $request->get('content');
        $message->phone_number = $request->tel;
        $message->email = $request->email;

        $message->save();

        $contact = ContactUs::all()->where('point' , '=' , 5)->take(4);
        Cache::put('contact', $contact, 500);

        return back()->with('message', 'پیام شما با موفقیت ثبت شد');
    }

    public function about()
    {
        $all = Post::all();
        $all_posts = $all->count();

        $active_posts = $all->where('is_active' , '=' , 1)->count();

        $posts = $all->where('is_active' , '=' , 1)
                         ->where('is_rent' , '=' , 0)->count();

        $rents = $all->where('is_active' , '=' , 1)
                     ->where('is_rent' , '=' , 1)->count();

        return view('pages.about' , compact('all_posts' , 'active_posts' , 'posts' , 'rents'));

    }
    public function rules()
    {
        return view('pages.rules');
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

    public function accessory(Request $request)
    {
        
        $accesses = Accessory::query();
        
        $data = array(
            'accesses' => $this->services($accesses , $request),
            'state' => State::all()
        );
    
        
        return view('accessory.index', $data);
    }

    public function lux(Request $request)
    {

        $luxes = Lux::query();
        
        $data = array(
            'luxes' => $this->services($luxes , $request),
            'state' => State::all()
        );

        return view('lux.index', $data);
    }

    public function insurance(Request $request)
    {
        
        $insurances = Insurance::query();
        
        $data = array(
            'insurances' => $this->services($insurances , $request),
            'state' => State::all()
        );

        return view('Insurance.index', $data);
    }


}
