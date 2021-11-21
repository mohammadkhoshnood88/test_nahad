<?php

namespace App\Http\Controllers;

use App\Models\MarkPost;
use App\Models\RentOffer;
use App\Models\UserPanel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    public function sendCode(Request $request)
    {
        $rand = rand(1000, 9999);
        $phone = $request->input('phone_number');
        
        sms($phone, $rand);

// 
        $user = UserPanel::where('phone_num', $phone)->first();
        if ($user) {
            $user->regCode = $rand;
            // $user->regCode = '1234';
        } else {
            $user = new UserPanel();
            $user->regCode = $rand;
            // $user->regCode = '1234';
            $user->phone_num = $phone;

        }

        $user->save();

        return response()->json(array('success' => true, "code" => $rand), 200);
    }

    public function checkCode(Request $request)
    {
        
        $code = $request->input('code');
        $phone = $request->input('phone_number');

        $user = UserPanel::where('phone_num', $phone)->where('regCode', $code)->first();
        // $user = UserPanel::where('phone_num', $phone)->where('regCode', '1234')->first();

        if ($user) {

            ///////// khabar az to /////////////////
            // $off = RentOffer::all()->where('phone_number' , '=' , $phone)->first();
            // if(!isset($off)){

            //     $noff = new Rentoffer;
            //     $noff->phone_number = $phone;
            //     $noff->save();
            // }
            ///////////////////////////////////////


            ////////////// mark check //////////////////

            $d = unserialize(\Illuminate\Support\Facades\Cookie::get('marks'));

            $marks = MarkPost::all()->where('user_id', '=', $user->id)->pluck('post_id')->toArray();


            if (is_array($d)) {

                foreach ($d as $m) {
                    if (!in_array($m, $marks)) {
                        $a = new MarkPost();
                        $a->post_id = $m;
                        $a->user_id = $user->id;
                        $a->save();
                    }
                }
            }

            \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::forget('marks'));


            ///////////////////////////



            Session::put('phone_number', $phone);
            Session::put('login', true);
            return response()->json(array('success' => true), 200);
        } else {
            return response()->json(array('success' => false, 'message' => 'کد وارد شده اشتباه است'), 200);
        }

    }

}
