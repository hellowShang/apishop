<?php

// 首页
Route::get('/', function () {
    return view('index');
});


// * 前台首页
Route::get('/home/index/','Controller\IndexController@index');

//商品列表展示
Route::get('/goodslist','Controller\GoodsController@goodslist');

//商品详情页展示
Route::get('/goods/detail/{goods_id}','Controller\GoodsController@detail');

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


//购物车
Route::post('/cart/cartadd/','Controller\CartController@cartadd');
Route::get('/cart/cartlist/','Controller\CartController@cartlist');
Route::post('/cart/cartdel/','Controller\CartController@cartdel');


// 支付宝支付
Route::get('pay','Controller\PayController@pay');
// 同步通知
Route::get('success','Controller\PayController@success');
// 异步通知
Route::get('notify','Controller\PayController@notify');

