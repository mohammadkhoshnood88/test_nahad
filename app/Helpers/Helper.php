<?php

use App\Models\VehicleMeta;
use Morilog\Jalali\Jalalian;


function city_name_old($id)
{
    $city = \App\Models\City::where('id', $id)->first();
    return $city->name;
}

function state_name($id)
{
    $state = \App\Models\State::where('id', $id)->first();
    return $state->name;
}

function model_name_old($id)
{
    $city = \App\Models\Cmodel::all()->where('id', '=', $id)->first();
    return $city->name;
}

function meta_name_old($id)
{
    $meta = VehicleMeta::all()->where('id', '=', $id)->first();
    return $meta->value;
}


function option_name($option)
{
    $options = [
        "instagram" => "آیدی ایسنتاگرام",
        "website" => "وب سایت",
        "ladder" => "نردبان",
        "special" => "ویژه",
        "urgent" => "فوری",
        "re_active" => "تمدید",
    ];

    return $options[$option];

}

function option_price($option , $time)
{
    $options = [
        "instagram" => 10,
        "website" => 10,
        "ladder" => 15,
        "special" => 46,
        "urgent" => 25,
        "re_active" => 0,
    ];

    if ($time != 1)
        $time = $time * 15 / 100;
    else
        $time = 0;

    return $options[$option] + $options[$option] * $time ;

}

function post_subject($id){
    $bind = ['id' => $id];
    $post = DB::select("
    select subject
    from posts
    where id = :id
    " , $bind);
    
    return $post[0]->subject;
}

function sms($mobile,$code){

        try{

            //$sender = "10008445";
            $receptor = $mobile;
            //$message = "باروکالا - کد اعتبار سنجی شما : " . $code;
//            $result = Kavenegar::Send($sender,$receptor,$message);

            $api = new Kavenegar\KavenegarApi("42666C41306956546D38426B6375364C56345459475666716B74513374506769");
            $result = $api->VerifyLookup($receptor,$code,null,null,"charkh-verify");
            return true;
        }
        catch(\Kavenegar\Exceptions\ApiException $e){
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            return false;
        }
        catch(\Kavenegar\Exceptions\HttpException $e){
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            return false;
        }
    

}


