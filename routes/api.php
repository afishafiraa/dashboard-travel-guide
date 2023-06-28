<?php

use Illuminate\Http\Request;

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
// Modul kode QR
Route::middleware('auth:api')->prefix('qr')->name('qr.')->group(function(){
  Route::get('generate/{id}', 'API\QrCodeController@generate')->name('generate');
  Route::get('scan/{id}', 'API\QrCodeController@scan')->name('scan');
});

Route::middleware('auth:api')->group(function(){
  // Modul Tourism
  Route::apiResource('tourism', 'API\TourismController');
  Route::get('/tourism-gallery/{id}', 'API\TourismController@gallery'); 
  Route::get('/tourism-city/{id}', 'API\TourismController@indexCity'); 

  // Modul Merchant
  Route::apiResource('merchant', 'API\MerchantController')->except([
    'update'
  ]);
  Route::put('merchant/update', 'API\MerchantController@update');
  Route::get('getmerchant', 'API\MerchantController@user');
  Route::get('merchant-category/{id}', 'API\MerchantController@category');

  // Modul Item
  Route::apiResource('items', 'API\MerchantItemController');
  
  // Modul Promo
  Route::apiResource('promo', 'API\PromoController');
  Route::get('getpromo', 'API\PromoController@user');
  
  // Modul User
  Route::put('user/update', 'API\UserController@update');
  Route::get('getUser', 'API\UserController@getUser');

  // Modul Reward
  Route::get('reward', 'API\RewardController@index');
  Route::get('reward-redeem/{id}', 'API\RewardController@reedem');
});
// Modul User login&register
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');