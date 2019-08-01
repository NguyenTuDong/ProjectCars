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
Route::get('/getlocations','HomeController@getLocations');
Route::get('/gettypes','HomeController@getTypes');
Route::get('/getbrands','HomeController@getBrands');
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

