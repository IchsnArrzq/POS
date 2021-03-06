<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $fillable = [
        'name',
        'merk_id',
        'distributor_id',
        'price_sell',
        'price_buy',
        'stock',
        'description'
    ];

    // Relation to distributor model
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    // Relation to merk model
    public function merk()
    {
        return $this->belongsTo(Merk::class);
    }

    public function goods()
    {
        return $this->hasMany(Cart::class);
    }
}
