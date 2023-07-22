<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('order')
            ->join('customer', 'order.customer_id', '=', 'customer.customer_id')
            ->select('order.*', 'customer.*')
            ->get();
    }
}
