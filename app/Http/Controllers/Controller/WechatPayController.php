<?php
namespace App\Http\Controllers\Controller;

use App\Model\UsreModel;
use App\Model\WechatUserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Model\Order;

class WechatPayController extends Controller
{
    public $values = [];
    // 支付接口调用
    public $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
    // 异步回调
    public $notify = "http://apishop.lab993.com/wechatnotify";

    /**
     * 测试-微信支付
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function pay(){
        $total_fee =1;                                              // 支付金额
        $out_trade_no = $_GET['order_no'];                          // 订单号

        // 判断PC还是手机
        $server_str = substr($_SERVER['HTTP_USER_AGENT'],strpos($_SERVER['HTTP_USER_AGENT'],'('),strpos($_SERVER['HTTP_USER_AGENT'],')')-10);
        if(substr_count($server_str,'Windows')){
            $info = [
                'appid' => env('APPID'),                        // 公众账号ID
                'mch_id' => env('MCH_ID'),                      // 商户号
                'nonce_str' => Str::random(16),                       // 随机字符串
                'body' => '微信订单支付',                                 // 商品描述
                'out_trade_no' => $out_trade_no,                      // 商户订单号
                'total_fee' => $total_fee,                             // 标价金额
                'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],          // 客户端ip
                'notify_url' => $this->notify,                        // 异步通知地址
                'trade_type' => 'NATIVE'                                // 交易类型
            ];
        }else{

            $info = [
                'appid' => env('APPID'),                        // 公众账号ID
                'mch_id' => env('MCH_ID'),                      // 商户号
                'nonce_str' => Str::random(16),                       // 随机字符串
                'body' => '微信订单支付',                                 // 商品描述
                'out_trade_no' => $out_trade_no,                      // 商户订单号
                'total_fee' => $total_fee,                             // 标价金额
                'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],          // 客户端ip
                'notify_url' => $this->notify,                        // 异步通知地址
                'trade_type' => 'JSAPI'                                // 交易类型
            ];
        }

        $this->values = $info;
        // 签名
        $this->getSign();
        // 数据转化成XML格式
        $XMLInfo = $this-> ToXml();
        // 请求支付接口
        $arr = $this-> postXmlCurl($XMLInfo,$this->url);

        if(substr_count($server_str,'Windows')){
            // XML数据转化成对象
            $data = simplexml_load_string($arr);

            // 将 code_url 返回给前端，前端生成 支付二维码
            return view("wechat.pay",['code_url' => $data->code_url,'order_sn' => $out_trade_no]);
        }else{
            echo "<pre>";print_r($arr);echo "</pre>";die;
        }
    }
    /**
     * 设计签名
     */
    public function getSign(){
        // 一、参数名ASCII码从小到大排序（字典序 A-Z排序）；
        ksort($this->values);
        // 二、签名拼接
        $str = "";
        foreach($this->values as $k => $v){
            if($k != 'sign' && $v != '' && !is_array($v)){
                $str .= $k . "=" . $v . "&";
            }
        }
        // 三、MD5加密并全部转化成大写
        $sign = strtoupper(md5($str."key=".env('MCH_KEY')));
        // 四、追加到$info里边
        $this->values['sign'] = $sign;
    }
    /**
     * 数据转化成XML格式
     * @return string
     */
    protected function ToXml()
    {
        if(!is_array($this->values)
            || count($this->values) <= 0)
        {
            die("数组数据异常！");
        }
        $xml = "<xml>";
        foreach ($this->values as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
    /**
     * 请求支付接口
     * @param $xml
     * @param $url
     * @param bool $useCert
     * @param int $second
     * @return mixed
     */
    private  function postXmlCurl($xml, $url, $useCert = false, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//		if($useCert == true){
//			//设置证书
//			//使用证书：cert 与 key 分别属于两个.pem文件
//			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
//			curl_setopt($ch,CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH);
//			curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
//			curl_setopt($ch,CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH);
//		}
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            die("curl出错，错误码:$error");
        }
    }
    // 异步通知
    public function notify(){
        $data = file_get_contents("php://input");
        //记录日志
        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
        file_put_contents('logs/wx_pay_notice.log',$log_str,FILE_APPEND);
        $xml = simplexml_load_string($data);
        if($xml->result_code=='SUCCESS' && $xml->return_code=='SUCCESS'){      //微信支付成功回调
            //验证签名
            $sign = true;
            if($sign){       //签名验证成功
                //TODO 逻辑处理  订单状态更新
                $order_no = $xml->out_trade_no;
                Order::where('order_no',$order_no)->update(['pay_status' => 2]);
            }else{
                //TODO 验签失败
                echo '验签失败，IP: '.$_SERVER['REMOTE_ADDR'];
                // TODO 记录日志
            }
        }
        $response = '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
        echo $response;
    }

    // 支付状态查询
    public function payStatus(){
        $order_sn = request()->order_sn;
        if(!$order_sn){
            die(json_encode(['font' => '订单不存在', 'code' =>   5]));
        }
        $arr = DB::table('order')->where(['order_no' => $order_sn])->first();

        if($arr->pay_status == 2){
            echo json_encode(['msg' => 'ok','order_sn' => $arr->order_no]);
        }
    }

    // 支付成功，消息显示
    public function success(){
        $order_sn = request()->order_sn;
        return view('wechat.success',['order_sn' => $order_sn]);
    }

    // 微信网页授权重定向
    public function wechatRedirect(){
        $redirect_url = urlencode('http://apishop.lab993.com/wechatlogin');
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHATAPPID').'&redirect_uri='.$redirect_url.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header('location:'.$url);
    }

    // 微信网页授权获取用户信息
     public function wechatLogin($code){
        // 获取access_token
        $access_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHATAPPID').'&secret='.env('WECAHTAPPSECRET').'&code='.$code.'&grant_type=authorization_code';
        $access_response = json_decode(file_get_contents($access_url),true);
        if(!isset($access_response['errcode'])){
            $openid = $access_response['openid'];
            $access_token = $access_response['access_token'];
        }

        // 获取用户信息
        $getUserInfo_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        $user_response = json_decode(file_get_contents($getUserInfo_url),true);
        return $user_response;
     }

     // 微信用户信息入库
    public function userInfoAdd(){
        // 获取code
        $code = $_GET['code'];
        // 获取用户信息
        $user_response = $this->wechatLogin($code);
        $openid = $user_response['openid'];
        // 判断是否关注   关注：欢迎   未关注：入库并欢迎
        $arr = WechatUserModel::where('openid',$openid)->first();
        if($arr){ // 关注
            if($arr['uid'] == ''){
                echo "<script>confirm( '是否绑定已有账号');location.href='/account?openid=$openid'</script>";
            }else{
                setcookie('uid',$arr->uid,time()+86400,'/',env('YUMING'),false,true);
                header('Refresh:3;url=/');
            }
        }else{ // 未关注
            // 首次登录，数据入库
            $info = [
                'sub_status' => 1,
                'openid' => $user_response['openid'],
                'nickname' => $user_response['nickname'],
                'sex' => $user_response['sex'],
                'city' => $user_response['city'],
                'province' => $user_response['province'],
                'country' => $user_response['country'],
                'headimgurl' => $user_response['headimgurl'],
                'subscribe_time' => time()
            ];

            $res = WechatUserModel::insert($info);
            if($res){
                echo "<script>confirm( '是否绑定已有账号');location.href='/account?openid=$openid'</script>";
            }else{
                echo "<script>alert( '授权失败，请重新授权');location.href='/user/login'</script>";
            }
        }
    }

     // 绑定已有账号页面
    public function account(){
        $data = [
            'openid' => request()->openid
        ];
        return view('wechat.account',$data);
    }

    // 绑定已有账号执行
    public function accountDo(){
        $account = request()->account;
        $openid = request()->openid;
        $pass = request()->password;
        $arr = UsreModel::where('name',$account)->first();
        if($arr){
            if($pass == $arr['pass']){
                $res = WechatUserModel::where('openid',$openid)->update(['uid' => $arr['uid']]);
                if($res){
                    setcookie('uid',$arr->uid,time()+86400,'/',env('YUMING'),false,true);
                    echo json_encode(['msg' => '绑定成功','num' => 2]);
                }else{
                    die(json_encode(['msg' => '绑定失败']));
                }
            }else{
                die(json_encode(['msg' => '密码错误']));
            }
        }else{
            die(json_encode(['msg' => '请先注册账号，再绑定','num' => 1]));
        }
    }
}
