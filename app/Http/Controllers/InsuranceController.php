<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\VisitInsurance;
use App\Models\MarkInsurance;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;
use Illuminate\Support\Facades\Session;


class InsuranceController extends BaseAdvertiseController
{
    protected $service;
    protected $model = Insurance::class;
    protected $table = 'insurances';
    protected $visit = VisitInsurance::class;
    protected $mark = MarkInsurance::class;


    public function index(Request $request)
    {
        $insurances = $this->getAll($request->term , $request->ajax());

        if ($request->ajax())
            return $insurances;

        return view('Insurance.index' , $insurances);
    }

    public function show($id)
    {

        list ($insurance, $mark) = $this->getItem($id);
        if($insurance)
            return view('Insurance.show' , compact('insurance' , 'mark'));
        else
            return abort(404);
            
            
    }

    public function create()
    {
        $states = State::all();

        return view('Insurance.create', compact('states'));
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
    
    public function store(Request $request)
    {
        if (\session()->get('key') == 'valid') {
            Session::forget('key');
            return redirect('insurance/create');
        }
        
        $verification = $this->verification($request);

        if($verification)
            return view('advertises.checkcode');
        else
            return redirect()->back()->with('failedsms', 'متاسفانه سامانه دچار اختلال شده است، لطفا لحظاتی دیگر مجددا تلاش فرمایید');            
    }    

    public function edit($id)
    {
        $phone_number = session()->get('phone_number' , 0);

        $data = Insurance::where('id' , $id)->where('own_delete' , 0)->first();
        $states = State::all();
        $cities = City::all();
        
        if($data && $phone_number == $data['phone_number'])
            return view('Insurance.edit' , compact('data' , 'states' , 'cities'));
        else
            return abort(404);
    }    
    

}
