<?php

namespace App\Http\Controllers\Controller;

use App\Model\Collect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CollectController extends Controller
{
    // 加入收藏
    public function collect(Request $request){
        $uid =  $_COOKIE['uid'];
        $goods_id = $request->goods_id;
        $arr = Collect::where(['uid' => $uid,'goods_id' => $goods_id])->first();
        if($arr){
            die(json_encode(['msg' => '已收藏过了']));
        }else{
            $res = Collect::insert(['uid' => $uid,'goods_id' => $goods_id]);
            if($res){
                die(json_encode(['msg' => '已收藏']));
            }else{
                die(json_encode(['msg' => '收藏失败']));
            }
        }
    }

    // 收藏展示
    public function collectShow(){
        $uid =  $_COOKIE['uid'];
       $collectInfo =  DB::table('collect')->join('goods','goods.goods_id','=','collect.goods_id')->where(['uid' => $uid])->get();
       $data = [
           'collectInfo' => $collectInfo
       ];
       return view('collect.list',$data);
    }

    // 删除收藏
    public function delCollect(){
        $goods_id = request()->goods_id;
        $uid = $_COOKIE['uid'];
        $res = Collect::where(['uid' => $uid,'goods_id' => $goods_id])->delete();
        if($res){
            die(json_encode(['msg' => '删除成功']));
        }else{
            die(json_encode(['msg' => '删除失败']));
        }
    }
}
