<?php

namespace App\Http\Controllers;

use App\Models\TournamentPersonalInfo;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index()
    {
        return 'tournament index';
    }

    public function create()
    {
        return "tounrnamet create";
    }

    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'mobile' => 'required|unique:tournament_personal_infos',
                'name' => 'required',
                'surname' => 'required',
                'national_code' => 'required|unique:tournament_personal_infos'
            ],
            [
                'mobile.required' => 'موبایل الزامی است',
                'mobile.unique' => 'این موبایل قبلا ثبت شده است',
                'national_code.unique' => 'این کد ملی قبلا ثبت شده است',
                'national_code.required' => 'کد ملی الزامی است',
            ]
        );

        $info = TournamentPersonalInfo::create($request);
        return back();
    }

}
