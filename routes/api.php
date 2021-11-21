<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
///////////////// V1 ///////////////

Route::prefix('v1')->group(function () {
    ///register

    Route::post('send/phone_number', [\App\Http\Controllers\Api\V1\CustomerController::class , 'check_phone_number']);
    
    Route::post('register', [\App\Http\Controllers\Api\V1\CustomerController::class , 'register']);
    
    Route::post('login', [\App\Http\Controllers\Api\V1\CustomerController::class , 'login']);
    Route::post('logout', [\App\Http\Controllers\Api\V1\CustomerController::class , 'logout']);
    Route::post('refresh', [\App\Http\Controllers\Api\V1\CustomerController::class , 'refresh']);

    ///

    Route::get('get/parameters', [\App\Http\Controllers\Api\V1\CustomerController::class , 'base_params']);
    Route::get('get/config', [\App\Http\Controllers\Api\V1\CustomerController::class , 'config']);
    Route::post('get/posts', [\App\Http\Controllers\Api\V1\CustomerController::class , 'posts']);
    Route::post('get/base/posts', [\App\Http\Controllers\Api\V1\CustomerController::class , 'base_posts']);
    Route::post('get/post/detail', [\App\Http\Controllers\Api\V1\CustomerController::class , 'post']);
    Route::post('get/related/posts', [\App\Http\Controllers\Api\V1\CustomerController::class , 'get_related_posts']);
    Route::post('get/filter/data' , [\App\Http\Controllers\Api\V1\CustomerController::class , 'filter']);
    Route::post('get/search/data' , [\App\Http\Controllers\Api\V1\CustomerController::class , 'search']);

    Route::post('store/post', [\App\Http\Controllers\Api\V1\CustomerController::class , 'store_post']);
    Route::post('store/image/post', [\App\Http\Controllers\Api\V1\CustomerController::class , 'store_image']);
    Route::post('delete/image/post', [\App\Http\Controllers\Api\V1\CustomerController::class , 'destroy_image']);
    Route::post('add/message', [\App\Http\Controllers\Api\V1\CustomerController::class , 'contact_us']);
    Route::post('get/ads/lux', [\App\Http\Controllers\Api\V1\CustomerController::class , 'get_ads_lux']);
    Route::post('get/ads/insurance', [\App\Http\Controllers\Api\V1\CustomerController::class , 'get_ads_insurance']);
    Route::post('get/ads/accessory', [\App\Http\Controllers\Api\V1\CustomerController::class , 'get_ads_accessory']);
    

    //// api with auth and token required
    Route::post('get/my/posts', [\App\Http\Controllers\Api\V1\CustomerController::class , 'my_posts'])->middleware(['checkToken', 'checkApi']);
    Route::post('set/mark/post', [\App\Http\Controllers\Api\V1\CustomerController::class , 'mark_post'])->middleware(['checkToken', 'checkApi']);
    Route::post('get/favorite/posts', [\App\Http\Controllers\Api\V1\CustomerController::class , 'favorite_posts'])->middleware(['checkToken', 'checkApi']);
    Route::post('get/destroy/post', [\App\Http\Controllers\Api\V1\CustomerController::class , 'destroy_post'])->middleware(['checkToken', 'checkApi']);
    Route::post('update/post', [\App\Http\Controllers\Api\V1\CustomerController::class , 'update_post'])->middleware(['checkToken', 'checkApi']);
    Route::post('report/problem', [\App\Http\Controllers\Api\V1\CustomerController::class , 'report_problem'])->middleware(['checkToken', 'checkApi']);
    
    
Route::prefix('financial')->group(function () {
    
    Route::post('cart', [\App\Http\Controllers\Api\V1\CustomerFinancialController::class , 'cart']);
    Route::post('store/upgrade', [\App\Http\Controllers\Api\V1\CustomerFinancialController::class , 'store_upgrade']);
    Route::post('remove/cart', [\App\Http\Controllers\Api\V1\CustomerFinancialController::class , 'remove_cart']);
    Route::post('invoice', [\App\Http\Controllers\Api\V1\CustomerController::class , 'invoice']);
    Route::post('request/pay', [\App\Http\Controllers\Api\V1\CustomerController::class , 'request_pay']);


});    


    Route::post('get/my/ads', [\App\Http\Controllers\Api\V1\CustomerAdvertiseController::class , 'my_ads'])->middleware(['checkToken', 'checkApi']);

    Route::prefix('ads')->group(function () {
        
        Route::post('/all', [\App\Http\Controllers\Api\V1\CustomerAdvertiseController::class , 'all']);

        Route::prefix('lux')->group(function () {

            Route::post('/', [\App\Http\Controllers\Api\V1\CustomerAdvertiseController::class , 'lux']);
            Route::post('store', [\App\Http\Controllers\Api\V1\CustomerAdvertiseController::class , 'lux_store']);
            Route::get('show/{id}', [\App\Http\Controllers\Api\V1\CustomerAdvertiseController::class , 'lux_show']);

        });

        Route::prefix('accessory')->group(function () {

            Route::post('/', [\App\Http\Controllers\Api\V1\CustomerAdvertiseController::class , 'accessory']);
            Route::post('store', [\App\Http\Controllers\Api\V1\CustomerAdvertiseController::class , 'accessory_store']);
            Route::get('show/{id}', [\App\Http\Controllers\Api\V1\CustomerAdvertiseController::class , 'accessory_show']);

        });

        Route::prefix('insurance')->group(function () {

            Route::post('/', [\App\Http\Controllers\Api\V1\CustomerAdvertiseController::class , 'insurance']);
            Route::post('store', [\App\Http\Controllers\Api\V1\CustomerAdvertiseController::class , 'insurance_store']);
            Route::get('show/{id}', [\App\Http\Controllers\Api\V1\CustomerAdvertiseController::class , 'accessory_show']);

        });
        
    });

    
    
    ////

});

Route::prefix('v2')->group(function () {
    
    Route::post('get/posts', [\App\Http\Controllers\Api\V2\PostController::class , 'posts']);

    Route::post('store/post', [\App\Http\Controllers\Api\V2\PostController::class , 'store_post'])->middleware(['checkToken', 'checkApi']);
    
});

////////////////////////////////////


