<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* ======================= Pages ======================= */

Route::get('/', 'HomeController@index');
Route::get('/about', 'HomeController@about');
Route::get('/contact', 'HomeController@contact');
Route::post('/contact', 'HomeController@store_contact_us')->name('contact_us');
Route::get('/rules', 'HomeController@rules');

Route::get('image' , 'AdvertisesController@image');


/* ======================= Lateral ======================= */

Route::get('/accessory', 'HomeController@accessory');
Route::post('/accessory', 'HomeController@accessory_search')->name('access_search');
Route::get('/accessory/create', 'AccessoryController@create');
Route::get('/insurance', 'HomeController@insurance');
Route::post('/insurance', 'HomeController@insurance_search')->name('ins_search');
Route::get('/insurance/create', 'InsuranceController@create');
Route::get('/lux', 'HomeController@lux');
Route::post('/lux', 'HomeController@lux_search')->name('lux_search');
Route::get('/lux/create', 'LuxController@create');



/* ======================= Addvertise ======================= */

Route::group(['prefix' => 'advertises'], function () {

    Route::get('show/{id}/{title?}', 'AdvertisesController@show');
    Route::get('all', 'AdvertisesController@index');
    Route::get('all/ajax', 'AdvertisesController@index_ajax');
    Route::get('create', 'AdvertisesController@create');
    Route::post('store', 'AdvertisesController@store');
    Route::get('verify', 'AdvertisesController@verify_post');

    //category type
    Route::get('types/{id}/{title?}', 'AdvertisesController@advertises_type');

});

/* ======================= Rent ======================= */

Route::group(['prefix' => 'rent'], function () {

    Route::get('show/{id}/{title?}', 'RentController@show');
    Route::get('all', 'RentController@index');
    Route::get('create', 'RentController@create');
    Route::post('store', 'RentController@store');
    Route::get('verify', 'RentController@verify_rent');

    //category type
    Route::get('types/{id}/{title?}', 'RentController@rent_type');

});

/* ======================= Lux ======================= */

Route::group(['prefix' => 'lux'], function () {

    Route::get('/', [\App\Http\Controllers\LuxController::class , 'index']);
    Route::get('show/{id}/{title?}', [\App\Http\Controllers\LuxController::class , 'show']);
    Route::get('create', [\App\Http\Controllers\LuxController::class , 'create']);
    Route::post('store', [\App\Http\Controllers\LuxController::class , 'store']);
    Route::get('verify', [\App\Http\Controllers\LuxController::class , 'verify']);
    Route::post('ajax/mark', [\App\Http\Controllers\LuxController::class , 'mark']);
});

/* ======================= Accessory ======================= */

Route::group(['prefix' => 'accessory'], function () {

    Route::get('/', [\App\Http\Controllers\AccessoryController::class , 'index']);
    Route::get('show/{id}/{title?}', [\App\Http\Controllers\AccessoryController::class , 'show']);
    Route::get('create', [\App\Http\Controllers\AccessoryController::class , 'create']);
    Route::post('store', [\App\Http\Controllers\AccessoryController::class , 'store']);
    Route::get('verify', [\App\Http\Controllers\AccessoryController::class , 'verify']);
    Route::post('ajax/mark', [\App\Http\Controllers\AccessoryController::class , 'mark']);
});

/* ======================= Insurance ======================= */

Route::group(['prefix' => 'insurance'], function () {

    Route::get('/', [\App\Http\Controllers\InsuranceController::class , 'index']);
    Route::get('show/{id}/{title?}', [\App\Http\Controllers\InsuranceController::class , 'show']);
    Route::get('create', [\App\Http\Controllers\InsuranceController::class , 'create']);
    Route::post('store', [\App\Http\Controllers\InsuranceController::class , 'store']);
    Route::get('verify', [\App\Http\Controllers\InsuranceController::class , 'verify']);
    Route::post('ajax/mark', [\App\Http\Controllers\InsuranceController::class , 'mark']);
});


/* ======================= UploadImageAdvertises ======================= */
Route::post('advertise/upload/image', [\App\Http\Controllers\BaseAdvertiseController::class , 'uploadImage']);


/* ======================= User ======================= */


Route::post('user/send/mobile', 'UserController@sendCode');
Route::post('user/send/code', 'UserController@checkCode');
Route::post('posts/getCity', 'MetaController@getCity');
Route::post('posts/ajax/models', 'MetaController@getModel');
Route::post('posts/get/meta', 'MetaController@get_meta');
Route::post('posts/ajax/posts', 'MetaController@getPosts');

Route::post('upload/image/ajax', 'MetaController@upload');


/* ======================= Mark ======================= */

Route::post('posts/ajax/mark', 'MetaController@mark_post');
Route::post('mark/cookie' , 'MetaController@mark_cookie');

Route::post('delete/mark' , 'MetaController@delete_mark');

/* ======================= Report Problem ======================= */

Route::post('/report/problem' , 'MetaController@report_problem');

/* ======================= Download App ======================= */

Route::get('/download/app' , 'MetaController@download_app');

/* ======================= User Panel ======================= */

Route::get('RA/{link}', 'MetaController@RA');

Route::group(['prefix' => 'userpanel'], function () {

    /*check code for all routes*/
    Route::post('/checkcode', 'UserPanelController@checkCode');


    Route::get('/index', 'UserPanelController@index');
    Route::get('/post/{id}/edit' , 'UserPanelController@edit');
    Route::post('/post/update' , 'UserPanelController@update');
    Route::post('/post/destroy' , 'UserPanelController@destroy');
    Route::post('/post/re_active' , 'FinancialController@just_re_active');

    Route::get('/myadvertises' , 'UserPanelController@my_advertise');
    Route::get('/markadvertises' , 'UserPanelController@mark_advertise');
    Route::get('/offer' , 'UserPanelController@offer');
    Route::get('/message' , 'UserPanelController@message');
    Route::post('/message' , 'UserPanelController@send_message');
    Route::get('/lateral' , 'UserPanelController@lateral');
    
    Route::get('/post/{id}/upgrade' , 'FinancialController@upgrade');
    Route::post('/post/upgrade' , 'UserPanelOptionsController@upgrade');
    
    
    ////////////// update lateral ////////////////
    
Route::group(['prefix' => 'accessory'], function () {

    Route::get('/{id}/edit', [\App\Http\Controllers\AccessoryController::class , 'edit']);
    Route::post('/{id}/update', [\App\Http\Controllers\AccessoryController::class , 'update'])->name('accessory_update');
    Route::post('/destroy', [\App\Http\Controllers\AccessoryController::class , 'destroy']);

    
    });    
    
Route::group(['prefix' => 'insurance'], function () {

    Route::get('/{id}/edit', [\App\Http\Controllers\InsuranceController::class , 'edit']);
    Route::post('/{id}/update', [\App\Http\Controllers\InsuranceController::class , 'update'])->name('insurance_update');
    Route::post('/destroy', [\App\Http\Controllers\InsuranceController::class , 'destroy']);
    
    });  
    
Route::group(['prefix' => 'lux'], function () {

    Route::get('/{id}/edit', [\App\Http\Controllers\LuxController::class , 'edit']);
    Route::post('/{id}/update', [\App\Http\Controllers\LuxController::class , 'update'])->name('lux_update');
    Route::post('/destroy', [\App\Http\Controllers\LuxController::class , 'destroy']);    
    
    });  

    
    
    //////////////////////////////////////////////////////////////

    Route::group(['prefix' => 'financial'], function () {

        Route::post('/urgent' , 'UserPanelOptionsController@urgent');
        Route::get('/ladder' , 'UserPanelOptionsController@ladder');

        // Route::get('/factor', 'FinancialController@factor');
        Route::get('post/{id}/cart', 'FinancialController@cart');
        Route::post('/option/remove', 'UserPanelOptionsController@remove_option');
        
        Route::get('post/{id}/factor', 'FinancialController@factor');
        
        Route::post('pay', 'FinancialController@request_pay')->name('request_pay');
        Route::get('response_pay/{id}', 'FinancialController@response_pay');

    });
    
     Route::get('/upgrade', 'UserPanelController@upgrade');
    Route::get('/logout' , 'UserPanelController@logout')->middleware('userLogin');

});



///////////////  tenant /////////////////
Route::post('tenant/store', 'UserPanelController@store_tenant')->name('tenant.store');
Route::post('tenant/get/ajax', 'UserPanelController@ajax_tenant');

Route::get('/preview' , function (){
    return view('advertises.preview');
});




///////////////////////////////////////////     admin    //////////////////////////////////////////////////////////


Route::resource('admins', 'AdminController');
// Route::patch('admin/{id}/delete' , 'AdminController@delete_post')->name('delete.post');
Route::post('/admin/delete/post' , 'AdminController@delete_post');
Route::get('admin/{id}/re_active' , 'AdminController@re_active_post')->name('re_active.post');
Route::get('/admin/dashboard', 'AdminController@dashboard');
Route::get('/admin/adm_register', 'AdminController@adm_register');
Route::get('/admin/adm_manage', 'AdminPostsController@adm_manage');
Route::get('/admin/new_post', 'AdminPostsController@create_new_post');
Route::post('/admin/store/new_post', 'AdminPostsController@store_new_post');
Route::get('/admin/adm_brand', 'AdminController@adm_brand');
Route::get('/admin/add_brand', 'AdminController@add_brand');
Route::get('/admin/edit_brand/{id}', 'AdminController@edit_brand');
Route::get('/admin/adm_model', 'AdminController@adm_model');
Route::post('/brandstore', 'AdminController@storebrand');
Route::post('/brandupdate/{id}', 'AdminController@updatebrand');
Route::get('/admin/adm_cbody', 'AdminController@adm_cbody');
Route::post('/cbodystore', 'AdminController@storecbody');
Route::post('/cmodelstore', 'AdminController@storecmodel');
Route::get('/admin/adm_year', 'AdminController@adm_year');
Route::post('/yearstore', 'AdminController@storeyear');
Route::get('/admin/adm_state', 'AdminController@adm_state');
Route::post('/statestore', 'AdminController@storestate');
Route::get('/admin/adm_city', 'AdminController@adm_city');
Route::post('/citystore', 'AdminController@storecity');
Route::get('/admin/adm_user', 'AdminController@adm_user');
Route::post('/admin/add_new_user', 'AdminController@add_new_user');
Route::get('/admin/adm_showuser/{id}', 'AdminController@adm_showuser');
Route::post('update/{id}', 'AdminController@update_user');
Route::get('/admin/roles', 'AdminPermissionsController@index');

Route::get('/admin/adm_received_message', 'AdminController@adm_received_message');
Route::get('/admin/adm_offer_message', 'AdminController@adm_offer_message');
Route::post('/admin/get/chat', 'AdminController@get_message');
Route::post('/admin/send/chat/response', 'AdminController@send_response_chat');
Route::post('/admin/send/response', 'AdminController@send_response_message');
Route::post('/statestore', 'AdminController@storestate');

Route::get('/admin/add_carIntro', 'AdminController@add_carIntro');
Route::post('/admin/add_carIntro', 'AdminController@store_car_intro')->name('add_carintro');
Route::post('/admin/remove/intro', 'AdminController@remove_car_intro');
Route::get('/admin/add_techcheckup', 'AdminController@index_tech_checkup');
Route::post('/admin/add_techcheckup', 'AdminController@add_tech_checkup')->name('add_tech_checkup');
Route::post('/admin/techcheckup/cities', 'AdminController@add_tech_checkup');
Route::get('/admin/types', 'AdminController@types')->name('types');
Route::post('/admin/add_types', 'AdminController@add_types')->name('add_types');
Route::get('/admin/advertise/lux', 'AdminController@advertise_lux');
Route::post('/admin/advertise/lux', 'AdminController@add_advertise_lux')->name('add_ads_lux');
Route::get('/admin/advertise/accessory', 'AdminController@advertise_accessory');
Route::post('/admin/advertise/accessory', 'AdminController@add_advertise_accessory')->name('add_ads_access');
Route::get('/admin/advertise/insurance', 'AdminController@advertise_insurance');
Route::post('/admin/advertise/insurance', 'AdminController@add_advertise_insurance')->name('add_ads_ins');



Route::get('admin/rent_ads_manage', 'AdminRentController@index');
Route::get('admin/rents/{id}/edit', 'AdminRentController@edit');
//Route::post('/admin/add_types', 'AdminController@add_types')->name('add_types');


Route::post('/admin/ajax/upload-file-post', 'AdminPostsController@uploadFile');
Route::post('/admin/ajax/delete-file-post', 'AdminPostsController@deleteFile');

Route::put('/admin/rent/update/{id}', 'AdminRentController@update');
Route::post('/admin/ajax/upload-file-rent', 'AdminRentController@uploadFile');
Route::post('/admin/ajax/delete-file-rent', 'AdminRentController@deleteFile');

// Route::post('/admin/ajax/upload-file-blog', 'AdminBlogController@uploadFile');
// Route::post('/admin/ajax/delete-file-blog', 'AdminBlogController@deleteFile');


Route::group(['prefix' => 'admin/lux'], function () {

    Route::get('/{id}/edit', [\App\Http\Controllers\admin\LuxController::class , 'edit']);
    Route::post('/{id}/update', [\App\Http\Controllers\admin\LuxController::class , 'update'])->name('admin_lux_update');
    Route::post('/destroy', [\App\Http\Controllers\admin\LuxController::class , 'destroy']);
    
    });  
    
Route::group(['prefix' => 'admin/accessory'], function () {

    Route::get('/{id}/edit', [\App\Http\Controllers\admin\AccessoryController::class , 'edit']);
    Route::post('/{id}/update', [\App\Http\Controllers\admin\AccessoryController::class , 'update'])->name('admin_accessory_update');
    Route::post('/destroy', [\App\Http\Controllers\admin\AccessoryController::class , 'destroy']);
    
    }); 
    
Route::group(['prefix' => 'admin/insurance'], function () {

    Route::get('/{id}/edit', [\App\Http\Controllers\admin\InsuranceController::class , 'edit']);
    Route::post('/{id}/update', [\App\Http\Controllers\admin\InsuranceController::class , 'update'])->name('admin_insurance_update');
    Route::post('/destroy', [\App\Http\Controllers\admin\InsuranceController::class , 'destroy']);
    
    }); 



Route::get('/admin/payments', 'AdminController@payments');
Route::post('/admin/clear/payment', 'AdminController@clear_payment');



Route::resource('admin', 'AdminPostsController');
Route::post('/admin', 'AuthController@authenticate');

Route::get('command', function(){
    
    \Artisan::call('route:cache');
    return "route:cache";
    
});




Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');


/* ======================= Financial ======================= */

Route::group(['prefix' => 'financial'], function () {

    Route::get('/factor', 'FinancialController@factor');
    Route::get('/cart', 'FinancialController@cart');

});



/* ======================= Tournament ======================= */

Route::group(['prefix' => 'tournament'], function () {

    Route::get('/index', 'TournamentController@index');
    Route::get('/create', 'TournamentController@create');
    Route::post('/store', 'TournamentController@store');

});



