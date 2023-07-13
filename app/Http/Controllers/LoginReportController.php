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
        $loggedInUsers = User::whereNotNull('last_login_at')->get();
        $loginrecords = LoginRecord::all();
        return view('reports/Loginreport', compact('loginrecords'));
    }

    public function exportLoginRecords()
    {
        return Excel::download(new LoginRecordsExport, 'login_records.xlsx');
    }
}
