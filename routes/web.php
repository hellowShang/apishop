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
    return view('layouts.app');
});


// * 前台首页
Route::get('/home/index','Controller\IndexController@index');

//商品列表展示
Route::get('/goodslist','Controller\GoodsController@goodslist');
