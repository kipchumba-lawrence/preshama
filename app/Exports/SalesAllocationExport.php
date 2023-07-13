<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesAllocationExport implements FromQuery, WithHeadings
{
    public function query()
    {
        return DB::table('users_app')
            ->join('material_allocation', 'material_allocation.user_id', '=', 'users_app.user_id')
            ->join('material', 'material_allocation.material_id', '=', 'material.material_id')
            ->select(
                'users_app.user_id',
                'users_app.first_name',
                'material.material_name',
                'material_allocation.amount',
                'material_allocation.allocation_id',
                DB::raw("DATE_FORMAT(material_allocation.allocation_date, '%d-%m-%Y') AS allocation_date")
            )
            ->orderBy('users_app.user_id'); // Add an orderBy clause based on your desired sorting
    }

    public function headings(): array
    {
        return [
            'User ID',
            'First Name',
            'Material Name',
            'Amount',
            'Allocation ID',
            'Allocation Date',
        ];
    }
}
