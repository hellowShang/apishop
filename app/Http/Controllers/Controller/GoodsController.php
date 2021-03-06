<?php

namespace App\Http\Controllers\Controller;

use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    // 商品列表
    public function goodslist()
    {
    	$list=GoodsModel::paginate(4);
        $data = [
            'list' => $list
        ]; 
    	return view('goods.index',$data);
    }

    //商品详情
    public function detail($goods_id)
    {
  
    	$goods = GoodsModel::where(['goods_id' =>$goods_id])->first();
    	 //商品不存在
       // print_r($goods);die;
        if(!$goods){
           	header('Refresh:2;url=/');
            echo '商品不存在,正在跳转至首页';
            exit;
        }
        $data = [
            'goods' => $goods
        ];
    	return view('goods.detail',$data);
    }
}