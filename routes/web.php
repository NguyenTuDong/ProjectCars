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

    //Car
    Route::get('/car', 'Admin\CarController@index');
    Route::get('/car/{id}', 'Admin\CarController@show');
    Route::post('/car/approve/{car}', 'Admin\CarController@approve');
    Route::post('/car/deny/{car}', 'Admin\CarController@deny');
    Route::post('/car/delete/{car}', 'Admin\CarController@destroy');

    //User
    Route::get('/user', 'Admin\UserController@index');
    Route::get('/user/{id}', 'Admin\UserController@show');

    //Contact
    Route::get('/contact', 'Admin\ContactController@index');
    Route::get('/contact/{id}', 'Admin\ContactController@show');

    //Brand
    Route::get('/brand', 'Admin\BrandController@index');
    Route::post('/brand', 'Admin\BrandController@store');
    Route::post('/brand/{brand}', 'Admin\BrandController@update');
    Route::post('/brand/delete/{brand}', 'Admin\BrandController@destroy');
    
    //Type
    Route::get('/type/{brands_id}', 'Admin\TypeController@index');
    Route::post('/type', 'Admin\TypeController@store');
    Route::post('/type/{type}', 'Admin\TypeController@update');
    Route::post('/type/delete/{type}', 'Admin\TypeController@destroy');

    //Color
    Route::get('/color', 'Admin\ColorController@index');
    Route::post('/color', 'Admin\ColorController@store');
    Route::post('/color/{color}', 'Admin\ColorController@update');
    Route::post('/color/delete/{color}', 'Admin\ColorController@destroy');
    
    //Condition
    Route::get('/condition', 'Admin\ConditionController@index');
    Route::post('/condition', 'Admin\ConditionController@store');
    Route::post('/condition/{condition}', 'Admin\ConditionController@update');
    Route::post('/condition/delete/{condition}', 'Admin\ConditionController@destroy');

    //Origin
    Route::get('/origin', 'Admin\OriginController@index');
    Route::post('/origin', 'Admin\OriginController@store');
    Route::post('/origin/{origin}', 'Admin\OriginController@update');
    Route::post('/origin/delete/{origin}', 'Admin\OriginController@destroy');

    //Fuel
    Route::get('/fuel', 'Admin\FuelController@index');
    Route::post('/fuel', 'Admin\FuelController@store');
    Route::post('/fuel/{fuel}', 'Admin\FuelController@update');
    Route::post('/fuel/delete/{fuel}', 'Admin\FuelController@destroy');

    //Transmission
    Route::get('/transmission', 'Admin\TransmissionController@index');
    Route::post('/transmission', 'Admin\TransmissionController@store');
    Route::post('/transmission/{transmission}', 'Admin\TransmissionController@update');
    Route::post('/transmission/delete/{transmission}', 'Admin\TransmissionController@destroy');
    
    //Style
    Route::get('/style', 'Admin\StyleController@index');
    Route::post('/style', 'Admin\StyleController@store');
    Route::post('/style/{style}', 'Admin\StyleController@update');
    Route::post('/style/delete/{style}', 'Admin\StyleController@destroy');
    
    //Convenient
    Route::get('/convenient', 'Admin\ConvenientController@index');
    Route::post('/convenient', 'Admin\ConvenientController@store');
    Route::post('/convenient/{convenient}', 'Admin\ConvenientController@update');
    Route::post('/convenient/delete/{convenient}', 'Admin\ConvenientController@destroy');
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

