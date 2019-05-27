<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    // 用户管理
    $router->resource('/user', UserController::class);
    // 商品管理
    $router->resource('/goods', GoodsController::class);
    // 购物车管理
    $router->resource('/cart', CartController::class);
    // 订单管理
    $router->resource('/order', OrderController::class);

});
