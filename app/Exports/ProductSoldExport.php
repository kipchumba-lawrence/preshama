<?php

namespace App\Exports;

use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductSoldExport implements FromQuery, WithHeadings
{
    public function query()
    {
        return DB::table('order_detail')
            ->join('material', 'order_detail.product_id', '=', 'material.material_id')
            ->join('order', 'order_detail.order_id', '=', 'order.order_id')
            ->join('customer', 'order.customer_id', '=', 'customer.customer_id')
            ->join('sales_person', 'customer.repid', '=', 'sales_person.repid')
            ->select(
                'material.material_name',
                'order_detail.amount',
                'order_detail.create_date',
                'order.tracking_no',
                'customer.customer_name',
                'material.standard_price'
            )
            ->orderByDesc('order_detail.create_date');
    }

    public function headings(): array
    {
        return [
            'Material Name',
            'Amount',
            'Create Date',
            'Tracking No',
            'Customer Name',
            'Standard Price',
        ];
    }
}
