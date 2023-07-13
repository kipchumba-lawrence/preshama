<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CollectionsExport implements FromQuery, WithHeadings
{
    public function query()
    {
        return DB::table('order')
            ->join('customer', 'order.customer_id', '=', 'customer.customer_id')
            ->join('sales_person', 'customer.repid', '=', 'sales_person.repid')
            ->select(
                'order.create_date',
                'customer.customer_name',
                'order.credit_manager_approval',
                'order.order_id',
                'order.operations_manager_approval',
                DB::raw('SUM(order.total_cost) as total_cost')
            )
            ->groupBy('order.order_id', 'order.create_date', 'customer.customer_name', 'order.credit_manager_approval', 'order.operations_manager_approval')
            ->orderBy('order.create_date'); // Add an orderBy clause based on your desired sorting
    }

    public function headings(): array
    {
        return [
            'Create Date',
            'Customer Name',
            'Credit Manager Approval',
            'Order ID',
            'Operations Manager Approval',
            'Total Cost',
        ];
    }
}
