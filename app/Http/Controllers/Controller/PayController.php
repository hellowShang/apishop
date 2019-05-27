<?php

namespace App\Http\Controllers\Controller;

use App\Model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayController extends Controller
{
    // 支付宝支付
    public function pay(Request $request){
        $url = 'https://openapi.alipaydev.com/gateway.do';
        $order_no = $request->order_no;
        $arr = Order::where(['order_no' => $order_no])->first();
        if(!$arr){
            die('该订单不存在');
        }elseif($arr->pay_status == 2){
            die('该订单已经支付过了');
        }elseif($arr-> order_status == 2){
            die('该订单已删除');
        }

        $order_data = [
            'subject'       => '商品订单支付',
            'out_trade_no'  => $order_no,
            'total_amount'  => $arr->order_amount,
            'product_code'  => 'QUICK_WAP_WAY',
        ];

        $data = [
            'app_id'        => env('APP_ID'),
            'method'        => 'alipay.trade.wap.pay',
            'format'        => 'JSON',
            'return_url'    => env('RETURN_URL'),
            'charset'       => 'utf-8',
            'sign_type'     => 'RSA2',
            'timestamp'     => date('Y-m-d H:i:s'),
            'version'       => 1.0,
            'notify_url'    => env('NOTIFY_URL'),
            'biz_content'   => json_encode($order_data),
        ];

        // 签名
        $sign = $this->sign($data);
        $data['sign'] = $sign;

        // 拼接参数
        $str = '';
        foreach($data as $k=> $v){
            $str .= $k . '=' .urlencode($v) . '&';
        }
        $new_url = $url .'?'.rtrim($str);
        header('location:'.$new_url);
    }

    // 签名
    public function sign($data){
        ksort($data);

        $str = '';
        foreach($data as $k=> $v){
            if($data[$k] != 'sign' && $v != '' && !is_array($v)){
                $str .= $k . '=' . $v . '&';
            }
        }
        $key = openssl_get_privatekey('file://'.storage_path('app/keys/private.pem'));
        openssl_sign(rtrim($str,'&'),$sign,$key,OPENSSL_ALGO_SHA256);
        return base64_encode($sign);
    }

    // 支付成功同步提示
    public function success(){
        echo "<span style='color:red;font-size: 20px;font-weight: bold;'>支付成功,订单号为：".$_GET['out_trade_no']."，支付宝交易号为：".$_GET['trade_no']."</span>";
        header('Refresh:3;url=/');
    }

    // 异步通知
    public function notify(){
        $data = $_POST;
        is_dir('logs') or mkdir('logs',0777,true);
        $str = date('Y-m-d H:i:s').json_encode($data,JSON_UNESCAPED_UNICODE)."\n\r";
        file_put_contents('logs/notify.log',$str,FILE_APPEND);

        // 验签
        $str = $this->checksign($data);
        $sign = base64_decode($data['sign']);
        $key = openssl_get_publickey('file://'.storage_path('app/keys/aliyunpublic.pem'));
        $res = openssl_verify($str,$sign,$key,OPENSSL_ALGO_SHA256);
        if($res){
            // 验签成功
            $order_no = $_POST['out_trade_no'];

            if($_POST['trade_status'] == 'TRADE_FINISHED') {
            }else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                Order::where('order_no',$order_no)->update(['pay_status' => 2]);
            }
            echo "success";
        }else{
            // 验签失败
            echo "fail";
        }
    }

    // 验签
    public function checksign($data){
        unset($data['sign']);
        unset($data['sign_type']);

        ksort($data);
        $str = '';
        foreach($data as $k => $v){
            if($data[$k] != 'sign' && $data[$k] != 'sign_type'){
                $str .= $k . '=' . $v . '&';
            }
        }
        return rtrim($str,'&');
    }
}
