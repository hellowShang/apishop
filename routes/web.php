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
//    return view();
});
//用户注册
Route::get('/user/reg','Controller\UserController@reg');
Route::post('/user/regadd','Controller\UserController@regadd');
//用户登录
Route::get('/user/login','Controller\UserController@login');
Route::post('/user/loginadd','Controller\UserController@loginadd');
//用户地址
Route::get('/user/address','Controller\AddressController@address');
Route::any('/user/getaddress','Controller\AddressController@getaddress');
Route::any('/user/addressadd','Controller\AddressController@addressadd');