<?php


Route::get('/', function () {
    return view('layouts.app');
});


//购物车
Route::get('/cart/cartAdd/','CartController@cartAdd');
Route::get('/cart/cartList/','CartController@cartList');









=======
    return view('index');
});


// 支付宝支付
Route::get('pay','Controller\PayController@pay');
// 同步通知
Route::get('success','Controller\PayController@success');
// 异步通知
Route::get('notify','Controller\PayController@notify');
>>>>>>> f51057191359506a4a56c4871c949cda0f5bcc1f
