<?php

namespace App\Http\Controllers\Controller;

use App\Model\GoodsModel;
use App\Model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class OrderController extends Controller
{
    // 订单生成
    public function orderCreate(){

    }

    // 订单展示
    public function orderList(){
//        $uid = $_COOKIE['uid'];
        $uid = 4;
        $orderInfo  = Order::where(['uid' => $uid,'order_status' => 1])->join('goods','goods.goods_id','=','order.goods_id')->get();
        $data = [
            'orderInfo'     => $orderInfo
        ];
        return view('order.list',$data);
    }

    // 删除订单
    public function deleteOrder(Request $request){
       $oid = $request->oid;
       $res = Order::where('oid',$oid)->update(['order_status' => 2]);
       if($res){
           die(json_encode(['msg' => '订单删除成功','num' => 1],JSON_UNESCAPED_UNICODE));
       }else{
           die(json_encode(['msg' => '订单删除失败','num' => 2],JSON_UNESCAPED_UNICODE));
       }
    }
}
