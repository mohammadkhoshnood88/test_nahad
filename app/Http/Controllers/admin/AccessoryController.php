<?php

namespace App\Http\Controllers\admin;

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
    protected $model = Accessory::class;
    protected $route = 'accessory';


    public function index()
    {
        return "index";
    }

    public function edit($id)
    {
        $accessory = $this->getItem($id);
        
        return view('admin.advertise.accessory_edit' , compact('accessory'));

    }

    
}
