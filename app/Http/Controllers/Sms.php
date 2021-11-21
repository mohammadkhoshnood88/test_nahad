<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kavenegar;
use Illuminate\Support\Facades\Http;



class Sms extends Controller
{
    public function sendcode($mobile,$code){


        try{

            //$sender = "10008445";
            $receptor = $mobile;
            //$message = "باروکالا - کد اعتبار سنجی شما : " . $code;
//            $result = Kavenegar::Send($sender,$receptor,$message);

            $api = new Kavenegar\KavenegarApi("42666C41306956546D38426B6375364C56345459475666716B74513374506769");
            $result = $api->VerifyLookup($receptor,$code,null,null,"charkh-verify");
            return $result;
        }
        catch(\Kavenegar\Exceptions\ApiException $e){
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
        catch(\Kavenegar\Exceptions\HttpException $e){
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
    }
    
    public function submit($mobile , $message){
        
        $response = Http::get("https://api.kavenegar.com/v1/42666C41306956546D38426B6375364C56345459475666716B74513374506769/sms/send.json?receptor=$mobile&sender=10002002000500&message=$message");


    }
    
    public function factor($mobile , $message){
        
        $response = Http::get("https://api.kavenegar.com/v1/42666C41306956546D38426B6375364C56345459475666716B74513374506769/sms/send.json?receptor=$mobile&sender=10002002000500&message=$message");


    }    

}
