<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UsreModel extends Model
{
    //
    public $table = 'user';
    public $timestamps = false;
    public $primaryKey = 'uid';
}