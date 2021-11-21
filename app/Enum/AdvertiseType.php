<?php
/**
 * Created by PhpStorm.
 * User: HepahhangRayaneh
 * Date: 16/05/2021
 * Time: 11:35
 */

namespace App\Enum;


class AdvertiseType
{
    const Post = 1;
    const Lux = 2;
    const Accessory = 3;
    const Insurance = 4;

    public static function alias($type)
    {
        switch ($type){

            case 1:
                return "آگهی خودرو";
            case 2:
                return "تبلیغات لوازم لوکس";
            case 3:
                return "تبلیغات لوازم جانبی";
            case 4:
                return "تبلیغات مرکز بیمه";
            default:
                return "آگهی خودرو";


        }
    }

}