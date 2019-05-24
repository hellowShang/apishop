<?php

namespace App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CartModel;
use App\Model\GoodsModel;

class CartController extends Controller
{
    //加入购物车
    public function cartadd(Request $request)
    {
        $goods_id = $request->input('gid');
        $user_id = $_COOKIE['uid'];
        if(empty($goods_id)){
            header('Refeash:2;url=/home/index/');
            echo '商品不存在，请重新选择。';
        }
        if(empty($user_id)){
            header('Refeash:2;url=/home/index/');
            echo '请先登录';
        }
        //入库
        $info = [
            'user_id' => $user_id,
            'goods_id' => $goods_id,
            'cart_quantity' => 1,     //购买数量  默认为 1
            'create_time' => time()
        ];
        $id = CartModel::insertGetId($info);
        if($id){
            $response = [
                'errcode' => 0,
                'errmsg' => '加入购物车成功'
            ];
        }else{
            $response = [
                'errcode' => 4003,
                'errmsg' => '加入购物车失败'
            ];
        }
        return $response;
    }

    //购物车列表展示
    public function cartlist()
    {
        //购物车数据 两表联查
        $cartInfo = CartModel::select('cart_quantity','goods.*')
            ->join('goods','goods.goods_id','=','cart.goods_id')
            ->where('cart.is_delete','=','1')
            ->get();

        $data = [
            'cartInfo' => $cartInfo
        ];
        return view('cart.cartList',$data);
    }

    //购物车删除
    public function cartdel(Request $request)
    {
        $goods_id = $request->input();
        if(!empty($goods_id)){
            $res = CartModel::where(['goods_id'=>$goods_id])->update(['is_delete'=>2]);
            if($res){
                $response = [
                    'errcode' => 0,
                    'errmsg' => 'success',
                    'data' => [
                        'gid' => $goods_id
                    ]
                ];
            }else{
                $response = [
                    'errcode' => 4001,
                    'errmsg' => '删除失败',
                ];
            }
        }else{
            $response = [
                'errcode' => 4002,
                'errmsg' => '商品id不存在',
            ];
        }
        return $response;
    }

}
