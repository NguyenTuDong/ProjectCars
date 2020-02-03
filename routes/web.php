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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::prefix('admin')->group(function() {
  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
  Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

  Route::get('/', 'Admin\AdminController@index')->name('admin.dashboard');

  Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
  Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
  Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');
  Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');


  Route::prefix('api')->group(function() {
    //Brand
    Route::get('/brand', 'Admin\BrandController@index')->name('brand.index');
    Route::post('/brand', 'Admin\BrandController@store')->name('brand.store');
    Route::post('/brand/{brand}', 'Admin\BrandController@update')->name('brand.update');
    Route::post('/brand/delete/{brand}', 'Admin\BrandController@destroy')->name('brand.destroy');
    
    //Type
    Route::get('/type/{brands_id}', 'Admin\TypeController@index')->name('type.index');
    Route::post('/type', 'Admin\TypeController@store')->name('type.store');
    Route::post('/type/{type}', 'Admin\TypeController@update')->name('type.update');
    Route::post('/type/delete/{type}', 'Admin\TypeController@destroy')->name('type.destroy');

    //Color
    Route::get('/color', 'Admin\ColorController@index')->name('color.index');
    Route::post('/color', 'Admin\ColorController@store')->name('color.store');
    Route::post('/color/{color}', 'Admin\ColorController@update')->name('color.update');
    Route::post('/color/delete/{color}', 'Admin\ColorController@destroy')->name('color.destroy');
    
    //Condition
    Route::get('/condition', 'Admin\ConditionController@index')->name('condition.index');
    Route::post('/condition', 'Admin\ConditionController@store')->name('condition.store');
    Route::post('/condition/{condition}', 'Admin\ConditionController@update')->name('condition.update');
    Route::post('/condition/delete/{condition}', 'Admin\ConditionController@destroy')->name('condition.destroy');

    //Origin
    Route::get('/origin', 'Admin\OriginController@index')->name('origin.index');
    Route::post('/origin', 'Admin\OriginController@store')->name('origin.store');
    Route::post('/origin/{origin}', 'Admin\OriginController@update')->name('origin.update');
    Route::post('/origin/delete/{origin}', 'Admin\OriginController@destroy')->name('origin.destroy');

    //Fuel
    Route::get('/fuel', 'Admin\FuelController@index')->name('fuel.index');
    Route::post('/fuel', 'Admin\FuelController@store')->name('fuel.store');
    Route::post('/fuel/{fuel}', 'Admin\FuelController@update')->name('fuel.update');
    Route::post('/fuel/delete/{fuel}', 'Admin\FuelController@destroy')->name('fuel.destroy');

    //Transmission
    Route::get('/transmission', 'Admin\TransmissionController@index')->name('transmission.index');
    Route::post('/transmission', 'Admin\TransmissionController@store')->name('transmission.store');
    Route::post('/transmission/{transmission}', 'Admin\TransmissionController@update')->name('transmission.update');
    Route::post('/transmission/delete/{transmission}', 'Admin\TransmissionController@destroy')->name('transmission.destroy');
    
    //Style
    Route::get('/style', 'Admin\StyleController@index')->name('style.index');
    Route::post('/style', 'Admin\StyleController@store')->name('style.store');
    Route::post('/style/{style}', 'Admin\StyleController@update')->name('style.update');
    Route::post('/style/delete/{style}', 'Admin\StyleController@destroy')->name('style.destroy');
    
    //Convenient
    Route::get('/convenient', 'Admin\ConvenientController@index')->name('convenient.index');
    Route::post('/convenient', 'Admin\ConvenientController@store')->name('convenient.store');
    Route::post('/convenient/{convenient}', 'Admin\ConvenientController@update')->name('convenient.update');
    Route::post('/convenient/delete/{convenient}', 'Admin\ConvenientController@destroy')->name('convenient.destroy');
  });
});

Route::get('/getbrands','HomeController@getBrands');
Route::get('/getlocations','HomeController@getLocations');
Route::get('/gettypes','HomeController@getTypes');
Route::get('/getconditions','HomeController@getConditions');
Route::get('/getorigins','HomeController@getOrigins');
Route::get('/gettransmissions','HomeController@getTransmissions');
Route::get('/getfuels','HomeController@getFuels');
Route::get('/getstyles','HomeController@getStyles');
Route::get('/getcolors','HomeController@getColors');
Route::get('/search','HomeController@search')->name('search');
Route::post('/contact','HomeController@contact')->name('contact');

Route::post('/user/updatecover','UserController@updateCover')->name('update.cover');
Route::post('/user/updateavatar','UserController@updateAvatar')->name('update.avatar');

Route::resource('car','CarController');
Route::resource('user','UserController');

Route::get('/{vue_capture?}', function () {
    return view('admin.dashboard');
})->where('vue_capture', '[\/\w\.-]*');

