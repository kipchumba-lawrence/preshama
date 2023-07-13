<?php

namespace App\Exports;

use App\Models\LoginRecord;
use Maatwebsite\Excel\Concerns\FromCollection;

class LoginRecordsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LoginRecord::all();
    }
}
