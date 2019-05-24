<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsModel extends Model
{
    //商品列表
    protected $table = 'goods';
    public $timestamps = false;
    public $primaryKey='goods_id';

}

