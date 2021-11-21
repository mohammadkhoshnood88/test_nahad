<?php

namespace App\Http\Controllers\admin;

use App\Models\Insurance;
use App\Models\VisitInsurance;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;
use Illuminate\Support\Facades\Session;


class InsuranceController extends BaseAdvertiseController
{
    protected $model = Insurance::class;
    protected $route = 'insurance';


    public function index()
    {
        return "index";
    }

    public function edit($id)
    {
        $insurance = $this->getItem($id);

        return view('admin.advertise.insurance_edit' , compact('insurance'));

    }

}
