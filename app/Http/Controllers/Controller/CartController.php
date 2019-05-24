<?php

namespace App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Model\CartModel;
use App\Model\GoodsModel;
use App\Http\Controllers\Controller;
class CartController extends Controller
{
    //加入购物车
    public function cartAdd(Request $request)
    {
        $goods_id = $request->input('id');
        var_dump($goods_id);
    }
    //购物车列表
    public function cartList()
    {
        //购物车数据 两表联查
//        $cartInfo = CartModel::get();
        $cartInfo = CartModel::select('cart_quantity','goods.*')
            ->join('goods','goods.goods_id','=','cart.goods_id')
            ->get();
//        var_dump($cartInfo->toArray());
//        die;
        $data = [
            'cartInfo' => $cartInfo
        ];
        return view('cart.cartList',$data);
    }
}
