<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\Goods;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price_buy' => 'required',
            'price_sell' => 'required',
            'stock' => 'required',
            'description' => 'required',
        ]);
        Cart::create([
            'goods_id' => Goods::findOrFail($request->name)->id,
            'name' => Goods::findOrFail($request->name)->name,
            'price_buy' => $request->price_buy,
            'price_sell' => $request->price_sell,
            'stock_input' => $request->input,
            'total' => $request->total,
            'description' => $request->description
        ]);
        $goods = Goods::findOrFail($request->name);
        $goods->update([
            'stock' => $request->stock
        ]);
        return redirect()->back();
    }
    public function delete($id)
    {

        $cart = Cart::findOrFail($id);
        $goods = Goods::findOrFail($cart->goods_id);
        $goods->update([
            'stock' => $goods->stock + $cart->stock_input
        ]);
        $cart->delete();
        return redirect()->back();
    }
}
