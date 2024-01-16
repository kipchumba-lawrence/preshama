<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoginRecord;
use App\Exports\LoginRecordsExport;
use Maatwebsite\Excel\Facades\Excel;


class LoginReportController extends Controller
{
    public function index()
    {
        $loginrecords = LoginRecord::orderBy('created_at', 'desc')->get();
        return view('Reports/LoginReport', compact('loginrecords'));
    }

    public function exportLoginRecords()
    {
        return Excel::download(new LoginRecordsExport, 'login_records.xlsx');
    }
}
