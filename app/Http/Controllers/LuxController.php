<?php

namespace App\Http\Controllers;

use App\Models\Lux;
use App\Models\VisitLux;
use App\Models\MarkLux;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;
use Illuminate\Support\Facades\Session;


class LuxController extends BaseAdvertiseController
{
    protected $service;
    protected $model = Lux::class;
    protected $table = 'luxes';
    protected $visit = VisitLux::class;
    protected $mark = MarkLux::class;


    public function index(Request $request)
    {
        $luxes = $this->getAll($request->term , $request->ajax());

        if ($request->ajax())
            return $luxes;
            
        return view('lux.index' , $luxes);
    }

    public function show($id)
    {

        list ($lux, $mark) = $this->getItem($id);
        if($lux)
            return view('lux.show' , compact('lux' , 'mark'));
        else
            return abort(404);            
            
    }

    public function create()
    {
        $states = State::all();

        return view('lux.create', compact('states'));
    }

    public function store(Request $request)
    {
        if (\session()->get('key') == 'valid') {
            Session::forget('key');
            return redirect('lux/create');
        }
        
        $verification = $this->verification($request);

        return view('advertises.checkcode');
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

        return view('lux.preview' , compact('request'));

    }
    
    public function edit($id)
    {
        $phone_number = session()->get('phone_number' , 0);

        $data = Lux::where('id' , $id)->where('own_delete' , 0)->first();
        $states = State::all();
        $cities = City::all();
        
        if($data && $phone_number == $data['phone_number'])
            return view('lux.edit' , compact('data' , 'states' , 'cities'));
        else
            return abort(404);
    } 
}
