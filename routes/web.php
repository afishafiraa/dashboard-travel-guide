<?php

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

Route::get('/', function () {
    return view('auth/login_coreui');
});
Route::get('/verified', function () {
    return view('welcome');
});

Route::get('/edit', function () {
  $promos = App\Promo::
  whereDate('end_time', '>=', date('Y-m-d'))
  ->where('max_cut', null)
  ->orderBy('created_at', 'desc')
  ->get();
  foreach ($promos as $key) {
    $key->max_cut = rand(5000,100000);
    $key->save();
  }
  return 'secc';
});

Auth::routes(['register' => false, 'verify' => true]);

Route::middleware('auth','role:admin')->prefix('admin')->name('admin.')->group(function(){
  Route::resource('profile', 'AdminController');
  Route::post('profile/set-photo/{id}', 'AdminController@changeava')->name('changeava');
  Route::get('/', 'HomeController@index')->name('home');
  //untuk route role admin
  Route::resource('merchant', 'UserMerchantController');
  Route::post('merchant/set-merchant/{id}', 'UserMerchantController@setMerchant')->name('setmerchant');
  Route::post('guide/set-status/{id}', 'UserGuideController@changeStatus')->name('setstatus');
  Route::resource('guide', 'UserGuideController');  
  Route::resource('tourism', 'TourismController');  
  Route::resource('item', 'MerchantItemController');
  Route::resource('places', 'MerchantController');  
  Route::post('places/highlight/{id}', 'MerchantController@highlight')->name('highlight');
  Route::resource('promo', 'PromoController');  
  Route::resource('reward', 'RewardController');  
  Route::resource('city', 'CityController');  
  Route::resource('report', 'ReportController');  
  Route::resource('transaction', 'TransactionController');  
  Route::resource('notification', 'NotificationController');
  Route::get('/notification-send/{id}', 'NotificationController@send')->name('notification.send'); 
  Route::resource('gallery', 'GalleryController');
  Route::get('/reedem-reward', 'RewardController@reedemIndex')->name('reward.reedem.index'); 
  Route::get('/places-store', 'MerchantController@indexStore')->name('places.storeindex'); 
  Route::get('/places-hotel', 'MerchantController@indexHotel')->name('places.hotelindex'); 
  Route::get('/places-restaurant', 'MerchantController@indexRestaurant')->name('places.restaurantindex'); 
  Route::get('/report-user', 'ReportController@indexU')->name('report.indexU'); 
  Route::get('/report-transaction', 'ReportController@indexT')->name('report.indexT'); 
  Route::get('/user-export', 'ReportController@export_excelU')->name('report.exportU');
  Route::get('/transaction-export', 'ReportController@export_excelT')->name('report.exportT');
  // Route::get('getUser', 'MerchantController@getUser')->name('getuser');
});

Route::middleware('auth','role:admin')->group(function(){
  Route::get('/get-email', 'NotificationController@getEmail')->name('get-email'); 
  Route::get('/monthly-ajax/{date?}', 'TransactionController@monthlyAjax')->name('monthly-ajax'); 
  Route::get('/monthly-data/{date?}', 'TransactionController@getMonthly')->name('monthly-trans');  
  Route::get('/monthly-user/{date?}', 'ReportController@getMonthly')->name('monthly-user'); 
});