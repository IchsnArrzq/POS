<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['goods_id','user_id','price_sell','stock','total'];
}
