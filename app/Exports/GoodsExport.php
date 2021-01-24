<?php

namespace App\Exports;

use App\Goods;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GoodsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Goods::all();
    }
    public function headings(): array
    {
        return ["id","name","goods_id","user_id","price","stock","description","created_at","updated_at"];
    }
}
