<?php

// * 前台首页
Route::get('/','Controller\IndexController@index');

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
//用户修改密码
Route::get('/user/passup','Controller\UserController@passup')->middleware('check');
Route::post('/user/passupdo','Controller\UserController@passupdo')->middleware('check');
//用户个人中心
Route::get('/user/center','Controller\UserController@center')->middleware('check');
//用户地址
Route::get('/user/address','Controller\AddressController@address')->middleware('check');
Route::any('/user/getaddress','Controller\AddressController@getaddress');
Route::any('/user/addressadd','Controller\AddressController@addressadd');
Route::any('/user/addresslist','Controller\AddressController@addresslist');
Route::any('/user/addressdel','Controller\AddressController@addressdel');
Route::any('/user/addressup','Controller\AddressController@addressup');
Route::any('/user/addressupdate','Controller\AddressController@addressupdate');


//购物车
Route::post('/cart/cartadd/','Controller\CartController@cartadd');
Route::get('/cart/cartlist/','Controller\CartController@cartlist');
Route::post('/cart/cartdel/','Controller\CartController@cartdel');

//订单生成
Route::get('/order/create','Controller\OrderController@orderCreate');
// 订单展示
Route::get('/order/list','Controller\OrderController@orderList');
// 订单删除
Route::get('/order/deleteOrder','Controller\OrderController@deleteOrder');

// 支付宝支付
Route::get('/pay','Controller\PayController@pay');
// 同步通知
Route::get('/success','Controller\PayController@success');
// 异步通知
Route::post('/notify','Controller\PayController@notify');

// 微信支付
Route::get('/wechatpay','Controller\WechatPayController@pay');
// 微信异步
Route::post('/wechatnotify','Controller\WechatPayController@notify');
// 微信轮询
Route::get('/payStatus','Controller\WechatPayController@payStatus');
// 支付成功提示
Route::get('/wechatsuccess','Controller\WechatPayController@success');


// 加入收藏
Route::post('/collect','Controller\CollectController@collect');
// 收藏展示
Route::get('/collectlist','Controller\CollectController@collectShow');
// 删除收藏
Route::get('/delcollect','Controller\CollectController@delCollect');

// 微信网页授权重定向
Route::get('/wechatredirect','Controller\WechatPayController@wechatRedirect');
// 微信网页授权
Route::get('/wechatlogin','Controller\WechatPayController@wechatLogin');