<?php

namespace App\Http\Controllers\Controller;

use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //主页
    public function index(){
        //最新商品
        $newInfo = GoodsModel::where(['is_new'=>1])->get()->take(4);

        //网站推荐
        $goodsInfo = GoodsModel::get();
        $data = [
            'newInfo' => $newInfo,
            'goodsInfo' => $goodsInfo
        ];
        return view('home.index',$data);
    }
}