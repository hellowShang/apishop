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
        return view('address.add');
    }
    public function getaddress(){
        $arr=AreaModel::get();
        $data=json_encode($arr,256);
        return $data;
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
    }
}