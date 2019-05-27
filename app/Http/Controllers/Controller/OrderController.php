<?php

namespace App\Http\Controllers\Controller;

use App\Model\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class OrderController extends Controller
{
    // 订单生成
    public function orderCreate(){
        $goods_id = request()->goods_id;
        $uid = $_COOKIE['uid'];
        if(!$uid){
            echo '请先登录';
            header('Refresh:3;url=/user/login');
        }
        $goods_id = rtrim($goods_id,',');
        if(strpos($goods_id,',')){
            $goods_id = explode(',',$goods_id);
        }

        // 开启事务
        DB::beginTransaction();

        // 捕获异常
        try{
            if(is_array($goods_id)){
                $cartInfo = DB::table('cart')
                    ->join('goods','goods.goods_id','=','cart.goods_id')
                    ->where(['is_delete' => 1,'user_id' => $uid])
                    ->whereIn('cart.goods_id',$goods_id)
                    ->get();
            }else{
                $cartInfo = DB::table('cart')
                    ->join('goods','goods.goods_id','=','cart.goods_id')
                    ->where(['cart.goods_id' => $goods_id,'cart.user_id' => $uid])
                    ->first();
            }

            if(!$cartInfo){
                throw new \Exception('购物车空空如也');
            }

            // 订单信息入库
            $orderInfo = [];
            $cartInfo = json_decode(json_encode($cartInfo),true);

            $order_no = $uid.time().rand(11111,99999);;
            $order_amount = 0;

            if(is_array($goods_id)){
                foreach($cartInfo as $k => $v){
                    $order_amount += $v['cart_quantity'] * $v['self_price'];
                }
            }else{
                $order_amount += $cartInfo['cart_quantity'] * $cartInfo['self_price'];
            }

            $orderInfo['order_no'] = $order_no;
            $orderInfo['order_amount'] = $order_amount;
            $orderInfo['uid'] = $uid;
            $orderInfo['create_time'] = time();
            $orderInfo['update_time'] = time();
            // 入库
            $order_id = DB::table('order')->insertGetId($orderInfo);
            if(!$order_id){
                throw new \Exception('订单信息写入失败');
            }


            // 订单详情入库
            $orderDetail = [];
            if(is_array($goods_id)){
                foreach($cartInfo as $k => $v){
                    $orderDetail[$k]['order_no'] = $order_no;
                    $orderDetail[$k]['goods_id'] = $v['goods_id'];
                    $orderDetail[$k]['uid'] = $uid;
                    $orderDetail[$k]['buy_number'] = $v['cart_quantity'];
                    $orderDetail[$k]['goods_price'] = $v['self_price'];
                    $orderDetail[$k]['goods_name'] = $v['goods_name'];
                    $orderDetail[$k]['goods_img'] = $v['goods_img'];
                    $orderDetail[$k]['create_time'] = time();
                    $orderDetail[$k]['update_time'] = time();
                }
            }else{
                $orderDetail['order_no'] = $order_no;
                $orderDetail['goods_id'] = $cartInfo['goods_id'];
                $orderDetail['uid'] = $uid;
                $orderDetail['buy_number'] = $cartInfo['cart_quantity'];
                $orderDetail['goods_price'] = $cartInfo['self_price'];
                $orderDetail['goods_name'] = $cartInfo['goods_name'];
                $orderDetail['goods_img'] = $cartInfo['goods_img'];
                $orderDetail['create_time'] = time();
                $orderDetail['update_time'] = time();
            }

            // 入库
            $res1 = DB::table('order_detail')->insert($orderDetail);
            if(!$res1){
                throw new \Exception('订单详情写入失败');
            }

            // 购物车数据删除(修改状态)
            if(is_array($goods_id)){
                $res2 = DB::table('cart')->where('user_id',$uid)->whereIn('goods_id',$goods_id)->update(['is_delete' => 2]);
            }else{
                $where = ['goods_id' => $goods_id,'user_id' => $uid];
                $res2 = DB::table('cart')->where($where)->update(['is_delete' => 2]);
            }

            if(!$res2){
                throw new \Exception('购物车数据删除失败');
            }

            //如果成功就提交
            DB::commit();
            die(json_encode(['errcode' => 0,'msg' => '下单成功','data' => ['order_no' => $order_no]]));
        }catch ( \Exception $e){
            //如果失败就回滚
            DB::rollback();
            echo $e->getMessage();
        }
    }

    // 订单展示
    public function orderList(){
        $uid = $_COOKIE['uid'];
        if(!$uid){
            echo '请先登录';
            header('Refresh:3;url=/user/login');
        }
        $orderInfo  = DB::table('order_detail')->where(['uid' => $uid,'status' => 1])->join('goods','goods.goods_id','=','order_detail.goods_id')->get();
        $data = [
            'orderInfo'     => $orderInfo
        ];
        return view('order.list',$data);
    }

    // 删除订单
    public function deleteOrder(Request $request){
       $oid = $request->oid;
       $res =  DB::table('order_detail')->where('id',$oid)->update(['status' => 2]);
       if($res){
           die(json_encode(['msg' => '订单删除成功','num' => 1],JSON_UNESCAPED_UNICODE));
       }else{
           die(json_encode(['msg' => '订单删除失败','num' => 2],JSON_UNESCAPED_UNICODE));
       }
    }
}
