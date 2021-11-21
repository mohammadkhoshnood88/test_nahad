<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Cmodel;
use App\Models\Cbody;
use App\Models\Cbrand;
use App\Models\Color;
use App\Models\WebSite;
use App\Models\InstagramId;
use App\Models\State;
use App\Models\City;
use App\Models\Type;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
// use mysql_xdevapi\Result;


class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        
        $validator = $request->validate([
            'email' => 'required',
            'password' => 'required|min:8'
        ]);

        $email = $request['email'];
        $password = $request['password'];
        
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/login');
        }
    }
}



    