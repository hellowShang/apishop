<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // 指定表名
    protected $table = 'order';
    public $timestamps = false;
    // 指定主键
    protected $primaryKey = 'oid';
}
