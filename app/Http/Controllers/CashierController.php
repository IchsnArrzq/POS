<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use App\Goods;
use App\Report;
use App\Transaction;

use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    public function index()
    {
        return view('main.cashier.index', [
            'goods' => DB::table("goods")->pluck('name', 'id'),
            'cart' => Cart::all(),
            'total' => Cart::get()->sum('total'),
            'stock' => Cart::get()->sum('stock_input'),
            'profit' => (Cart::get()->sum('price_sell') - Cart::get()->sum('price_buy')) * Cart::get()->sum('stock_input')

        ]);
    }
    public function pay($id)
    {
        // return redirect()->back()->with('pay',Goods::findOrFail($id));
    }
    public function get($id)
    {
        $get = DB::table("goods")
            ->where("id", $id)
            ->get();
        return json_encode($get);
    }
    public function purchase(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'profit' => 'required',
            'price_sell' => 'required',
            'price_buy' => 'required',
            'description' => 'required',
            'input' => 'required',
            'stock_input' => 'required',
            'money' => 'required',
            'total' => 'required',
            'returns' => 'required'
        ]);
        $names = '';
        foreach($request->name as $name){
            $names .= $name.', ';
        }
        Report::create([
            'name' => $names,
            'profit' => $request->profit,
            'input' => $request->input,
            'money' => $request->money,
            'total' => $request->total,
            'returns' => $request->returns
        ]);
        for ($var = 0; $var < count($request->name); $var++) {
            Transaction::create([
                'goods_id' =>  $request->id[$var],
                'user_id' => auth()->user()->id,
                'price_sell' => $request->price_sell[$var],
                'stock' => $request->stock_input[$var],
                'total' => $request->stock_input[$var] * $request->price_sell[$var]
            ]);
            Cart::where('id', $request->id[$var])->delete();
        }

        return redirect()->back()->with('success', 'Transaction Success');
    }
}
