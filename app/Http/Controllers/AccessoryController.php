<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\MarkAccessory;
use App\Models\VisitAccessory;
use App\Services\MainService;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;



class AccessoryController extends BaseAdvertiseController
{
    protected $service;
    protected $model = Accessory::class;
    protected $table = 'accessories';
    protected $visit = VisitAccessory::class;
    protected $mark = MarkAccessory::class;

    public function index(Request $request)
    {
        
        $accessories = $this->getAll($request->term , $request->ajax());

        if ($request->ajax())
            return $accessories;

        return view('accessory.index' , $accessories);
    }

    public function show($id)
    {
        list ($accessory, $mark) = $this->getItem($id);
        if($accessory)
            return view('accessory.show' , compact('accessory' , 'mark'));
        else
            return abort(404);
    }

    public function create()
    {
        $states = State::all();

        return view('accessory.create', compact('states'));
    }
    
    public function store(Request $request)
    {
        if (\session()->get('key') == 'valid') {
            Session::forget('key');
            return redirect('accessory/create');
        }
        
        $verification = $this->verification($request);
        
        if($verification)
            return view('advertises.checkcode');
        else
            return redirect()->back()->with('failedsms', 'متاسفانه سامانه دچار اختلال شده است، لطفا لحظاتی دیگر مجددا تلاش فرمایید');            
    }

    public function verify()
    {
        
        $url = explode('/', url()->previous());


        if (\session()->get('key') != 'valid' || end($url) != 'store') {
            Session::forget('key');
            abort('403', "کجا میای داداش؟");
        }
        
        
        $request = session()->get('request');
        $request['id'] = $this->addItem($request);
        
        \session()->put('login', true);
        \session()->put('phone_number', $request['phone_number']);
        Session::forget(['key', 'request']);

        return view('accessory.preview' , compact('request'));

        
    }
    
    public function edit($id)
    {
        $phone_number = session()->get('phone_number' , 0);

        $accessory = Accessory::where('id' , $id)->where('own_delete' , 0)->first();
        $states = State::all();
        $cities = City::all();
        
        if($accessory && $phone_number == $accessory['phone_number'])
            return view('accessory.edit' , compact('accessory' , 'states' , 'cities'));
        else
            return abort(404);
    }


}
