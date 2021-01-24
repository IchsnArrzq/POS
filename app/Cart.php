<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $fillable = [
        'goods_id',
        'name',
        'price_buy',
        'price_sell',
        'stock_input',
        'total',
        'description'
    ];
    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }
}
