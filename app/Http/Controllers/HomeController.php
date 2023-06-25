<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ward;
use App\Models\Order;
use App\Models\Youth;
use App\Models\SalesRep;
use Illuminate\Http\Request;
use App\Http\Controllers\Reports;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;



class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->user_type == 'Admin') {
            $users = User::all();
            return view('admin.users.show', compact('users'));
        }
        if (Auth::user()->user_type == 'Credit Manager') {
            $orders = Order::whereNull('credit_manager_approval')->get();
            return view('creditmanager.unapproved', compact('orders'));
        }

        if (Auth::user()->user_type == 'Operations Manager') {
            $orders = Order::whereNull('operations_manager_approval')->whereNotNull('credit_manager_approval')->get();
            return view('operationmanager.unapproved', compact('orders'));
        }
        if (Auth::user()->user_type == 'Procurement Officer') {

            $materials = collect(DB::select("SELECT * FROM `material` WHERE material.material_id NOT IN (SELECT material_id FROM `material_allocation`)"));
            $salesmen = User::where('user_type', 'Sales Manager')->get();

            return view('procurementofficer.allocation', compact('materials', 'salesmen'));
        }
        if (Auth::user()->user_type == 'Manager') {
            $sales_rep = SalesRep::select('first_name', 'last_name', 'repid')->get();
            $orders = Order::with('customer')->get();
            return view('Reports.sales', compact('orders',  'sales_rep'));
        } else {
            route('logout');
        }
    }
}
