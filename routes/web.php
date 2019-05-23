<?php

Route::get('/', function () {
<<<<<<< HEAD
    return view('layouts.app');
});


// * 前台首页
Route::get('/home/index','Controller\IndexController@index');

//商品列表展示
Route::get('/goodslist','Controller\GoodsController@goodslist');
=======
    return view('index');
});
<<<<<<< HEAD
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
=======


//购物车
Route::get('/cart/cartAdd/','CartController@cartAdd');
Route::get('/cart/cartList/','CartController@cartList');


// 支付宝支付
Route::get('pay','Controller\PayController@pay');
// 同步通知
Route::get('success','Controller\PayController@success');
// 异步通知
Route::get('notify','Controller\PayController@notify');
>>>>>>> 9351d9555901bf4a0cc553611f35bf48046e2f3f
>>>>>>> 3cf939b0a6ebc7f488129a1f0f02fe437f88d340
