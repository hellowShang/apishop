<?php

namespace App\Http\Controllers\Controller;

use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //主页
    public function index()
    {
        //最新商品
        $newInfo = GoodsModel::where(['is_new' => 1])->get()->take(4);

        //最热商品
        $hotInfo = GoodsModel::where(['is_hot' =>1])->get()->take(4);



        //网站推荐
        $goodsInfo = GoodsModel::paginate(6);
        $data = [
            'newInfo'   =>   $newInfo,
            'goodsInfo' =>   $goodsInfo,
            'hotInfo'   =>   $hotInfo
        ];
        return view('home.index', $data);
    }
}