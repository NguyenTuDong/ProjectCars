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

  Route::get('/', 'AdminController@index')->name('admin.dashboard');

  Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
  Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
  Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');
  Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});

//Brand
Route::resource('/brand', 'BrandController');

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


