<?php

namespace App\Http\Controllers\admin;

use App\Models\Lux;
use App\Models\VisitLux;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;
use Illuminate\Support\Facades\Session;


class LuxController extends BaseAdvertiseController
{
    protected $model = Lux::class;
    protected $route = 'lux';


    public function index()
    {
        return "index";
    }

    public function edit($id)
    {

        $lux = $this->getItem($id);

        return view('admin.advertise.lux_edit' , compact('lux'));

    }
}
