<?php

namespace App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;
use App\Model\UsreModel;
class UserController extends Controller
{
    public function reg(){
        return view('user.reg');
    }
    public function regadd(Request $request){
        $name=$request->input('name');
        $email=$request->input('email');
        $pass1=$request->input('pass1');
        $pass2=$request->input('pass2');
        $age=$request->input('age');
        $tel=$request->input('tel');
        if(empty($name)){
            return json_encode(['code'=>1,'msg'=>'用户名不能为空']);
        }
        if(empty($email)){
            return json_encode(['code'=>1,'msg'=>'邮箱不能为空']);
        }
        if(empty($pass1)){
            return json_encode(['code'=>1,'msg'=>'密码不能为空']);
        }
        if(empty($pass2)){
            return json_encode(['code'=>1,'msg'=>'确认密码不能为空']);
        }
        if(empty($age)){
            return json_encode(['code'=>1,'msg'=>'年龄不能为空']);
        }
        if(empty($tel)){
            return json_encode(['code'=>1,'msg'=>'手机号不能为空']);
        }
        if($pass2!=$pass1){
            return json_encode(['code'=>1,'msg'=>'两次输入密码不一致']);
        }
        $arr=UsreModel::where('name',$name)->first();
        if(empty($arr)){
            $data=[
                'name'=>$name,
                'age'=>$age,
                'pass'=>$pass1,
                'email'=>$email,
                'tel'=>$tel,
                'add_time'=>time()
            ];
            $res=UsreModel::insert($data);
            if($res){
                return json_encode(['code'=>0,'msg'=>'注册成功']);
            }else{
                return json_encode(['code'=>1,'msg'=>'注册失败']);
            }
        }else{
            return json_encode(['code'=>2,'msg'=>'已经有此用户，去登录']);
        }
    }
    public function login(){
        return view('user.login');
    }
    public function loginadd(Request $request){
        $name=$request->input('name');
        $pass=$request->input('pass');
        $arr=UsreModel::where('name',$name)->first();
        $yuming=env('YUMING');
        if($arr){
            if($arr['pass']==$pass){
                setcookie('uid',$arr->uid,time()+86400,'/',$yuming,false,true);
                return json_encode(['code'=>0,'msg'=>'登录成功']);
            }else{
                return json_encode(['code'=>1,'msg'=>'密码错误']);
            }
        }else{
            return json_encode(['code'=>2,'msg'=>'没有有此用户，去注册']);
        }
    }
    public function xian(){
        $uid=$_COOKIE['uid'];
        $data=UsreModel::where('uid',$uid)->first()->toArray();
        return $data;
    }
    public function exit(){
        $yuming=env('YUMING');
        $uid=$_COOKIE['uid'];
        setcookie('uid',"",time()-1,'/',$yuming,false,true);
        if(empty($uid)){
            return json_encode(['code'=>1,'msg'=>'你还没有登录'],256);
        }else{
            return json_encode(['code'=>0,'msg'=>'退出成功'],256);
        }
    }
    public function passup(){
        return view('user.pass');
    }
    public function passupdo(Request $request){
        $uid=$_COOKIE['uid'];
        $pass=$request->input('pass');
        $pass1=$request->input('pass1');
        $pass2=$request->input('pass2');
        if(empty($pass)){
            return json_encode(['code'=>1,'msg'=>'原密码不能为空']);
        }
        if(empty($pass1)){
            return json_encode(['code'=>1,'msg'=>'密码不能为空']);
        }
        if(empty($pass2)){
            return json_encode(['code'=>1,'msg'=>'确认密码不能为空']);
        }
        $arr=UsreModel::where('uid',$uid)->first();
        if($pass==$arr['pass']){
            if($pass2!=$pass1){
                return json_encode(['code'=>1,'msg'=>'两次输入密码不一致']);
            }else{
                $data=UsreModel::where('uid',$uid)->update(['pass'=>$pass2]);
                if($data){
                    return json_encode(['code'=>0,'msg'=>'修改成功']);
                }else{
                    return json_encode(['code'=>1,'msg'=>'修改失败']);
                }
            }
        }else{
            return json_encode(['code'=>1,'msg'=>'原密码错误']);
        }
    }
    public function center(){
        $uid=$_COOKIE['uid'];
        $arr=UsreModel::where('uid',$uid)->first()->toArray();
        return view('user.center',['arr'=>$arr]);
    }
}