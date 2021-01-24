<?php

namespace App\Http\Controllers;

use App\Goods;
use App\Report;
use App\Transaction;
use PDF;
use App\Export;
use Excel;
use App\Exports\ReportExport;
use App\Exports\GoodsExport;

class ManagerController extends Controller
{
    public function index()
    {
        return view('main.manager.index',[
            'reports' => Report::get(),
            'stock' => Report::get()->sum('stock'),
            'total' => Report::get()->sum('total'),
            'count' => Goods::get()->sum('stock'),
            'goods' => Goods::get()->count(),
            'transactions' => Transaction::get(),
            'goodst' => Goods::get(),
            'profit' => Report::get()->sum('profit')
        ]);
    }

    public function date()
    {
        $data = Goods::orderBy('created_at')->get();

        return view('main.manager.index',[
            'reports' => Report::get(),
            'stock' => Report::get()->sum('stock'),
            'total' => Report::get()->sum('total'),
            'count' => Goods::get()->sum('stock'),
            'goods' => Goods::get()->count(),
            'transactions' => Transaction::get(),
            'goodst' => $data
        ]);
    }

    public function stock()
    {
        $data = Goods::orderBy('stock')->get();

        return view('main.manager.index',[
            'reports' => Report::get(),
            'stock' => Report::get()->sum('stock'),
            'total' => Report::get()->sum('total'),
            'count' => Goods::get()->sum('stock'),
            'goods' => Goods::get()->count(),
            'transactions' => Transaction::get(),
            'goodst' => $data
        ]);
    }

    public function print_pdf()
    {
        $transactions = Transaction::get();
        $goods = Goods::get();

    	$pdf = PDF::loadview('main.manager.transaction_pdf',compact('transactions','goods'));
        // return $pdf->download('report-transaction-pdf');
        return $pdf->stream();
    }

    public function export_excel() {
        return Excel::download(new ReportExport, 'report_transaction.xlsx');
    }

    public function export_goods() {
        return Excel::download(new GoodsExport, 'report_goods.xlsx');
    }
}
