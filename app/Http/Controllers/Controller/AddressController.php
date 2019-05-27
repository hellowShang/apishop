<?php

namespace App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;
use App\Model\AreaModel;
use App\Model\AddressModel;

class AddressController extends Controller
{
    public function address(){
        $arr=AreaModel::where(['pid'=>0])->get()->toArray();
        return view('address.add',['arr'=>$arr]);
    }
    public function getaddress(){
        $id=$_POST['id'];
        if(empty($id)){
            return json_encode(['code'=>2,'msg'=>'请选择省份']);
        }
        $arr=AreaModel::where(['pid'=>$id])->get()->toArray();
        return json_encode($arr,256);
    }
    public function addressadd(Request $request){
        $uid=$_COOKIE['uid'];
        $address_name=$request->input('address_name');
        $address_tel=$request->input('address_tel');
        $address_detailed=$request->input('address_detailed');
        $province=$request->input('province');
        $city=$request->input('city');
        $area=$request->input('area');
        $is_status=$request->input('is_status');
        $address_time=time();
        if($is_status==1){
            AddressModel::where('uid',$uid)->update(['is_status'=>0]);
        }
        if(empty($uid)){
            return json_encode(['code'=>2,'msg'=>'你还没有登录，去登录']);
        }
        if(empty($address_name)){
            return json_encode(['code'=>1,'msg'=>'地址所属姓名不能为空']);
        }
        if(empty($address_tel)){
            return json_encode(['code'=>1,'msg'=>'地址所属电话不能为空']);
        }
        if(empty($address_detailed)){
            return json_encode(['code'=>1,'msg'=>'详细地址信息不能为空']);
        }
        if(empty($province)){
            return json_encode(['code'=>1,'msg'=>'省份不能为空']);
        }
        if(empty($city)){
            return json_encode(['code'=>1,'msg'=>'城市不能为空']);
        }
        if(empty($area)){
            return json_encode(['code'=>1,'msg'=>'区县不能为空']);
        }
        $data=[
            'address_name'=>$address_name,
            'address_tel'=>$address_tel,
            'address_detailed'=>$address_detailed,
            'province'=>$province,
            'city'=>$city,
            'area'=>$area,
            'address_time'=>$address_time,
            'is_status'=>$is_status,
            'uid'=>$uid
        ];
        $arr=AddressModel::insert($data);
        if($arr){
            return json_encode(['code'=>0,'msg'=>'添加成功']);
        }else{
            return json_encode(['code'=>1,'msg'=>'添加失败']);
        }
    }
    public function addresslist(){
        $uid=$_COOKIE['uid'];
        $where=[
            'uid'=>$uid,
            'is_del'=>0
        ];
        $data=AddressModel::where($where)->get()->toArray();
        return view('address.list',['data'=>$data]);
    }
    public function addressdel(Request $request){
        $uid=$_COOKIE['uid'];
        $address_id=$request->input('address_id');
        $where=[
            'uid'=>$uid,
            'address_id'=>$address_id
        ];
        $data=AddressModel::where($where)->update(['is_del'=>1]);
        if($data){
            return json_encode(['code'=>0,'msg'=>'删除成功']);
        }else{
            return json_encode(['code'=>1,'msg'=>'删除失败']);
        }
    }
    public function addressup(Request $request)
    {
        $address_id = $request->input('address_id');
        $where = [
            'address_id' => $address_id
        ];
        $data = AddressModel::where($where)->first()->toArray();
        $arr=AreaModel::where(['pid'=>0])->get()->toArray();
        return view('address.update', ['data' => $data,'arr'=>$arr]);
    }
    public function addressupdate(Request $request){
        $uid=$_COOKIE['uid'];
        $address_name=$request->input('address_name');
        $address_id=$request->input('address_id');
        $address_tel=$request->input('address_tel');
        $address_detailed=$request->input('address_detailed');
        $province=$request->input('province');
        $city=$request->input('city');
        $area=$request->input('area');
        $is_status=$request->input('is_status');
        $update_time=time();
        if($is_status==1){
            AddressModel::where('uid',$uid)->update(['is_status'=>0]);
        }
        if(empty($uid)){
            return json_encode(['code'=>2,'msg'=>'你还没有登录，去登录']);
        }
        if(empty($address_name)){
            return json_encode(['code'=>1,'msg'=>'地址所属姓名不能为空']);
        }
        if(empty($address_tel)){
            return json_encode(['code'=>1,'msg'=>'地址所属电话不能为空']);
        }
        if(empty($address_detailed)){
            return json_encode(['code'=>1,'msg'=>'详细地址信息不能为空']);
        }
        if(empty($province)){
            return json_encode(['code'=>1,'msg'=>'省份不能为空']);
        }
        if(empty($city)){
            return json_encode(['code'=>1,'msg'=>'城市不能为空']);
        }
        if(empty($area)){
            return json_encode(['code'=>1,'msg'=>'区县不能为空']);
        }
        $data=[
            'address_name'=>$address_name,
            'address_tel'=>$address_tel,
            'address_detailed'=>$address_detailed,
            'province'=>$province,
            'city'=>$city,
            'area'=>$area,
            'update_time'=>$update_time,
            'is_status'=>$is_status,
        ];
        $res=AddressModel::where('address_id',$address_id)->update($data);
        if($res){
            return json_encode(['code'=>0,'msg'=>'修改成功']);
        }else{
            return json_encode(['code'=>1,'msg'=>'修改失败']);
        }
    }
}