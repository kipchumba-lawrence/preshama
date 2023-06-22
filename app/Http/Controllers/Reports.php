<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Material;
use App\Models\SalesRep;
use App\Models\User_app;
use App\Models\Order_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DistributionChannel;
use App\Models\Material_Allocation;
use App\Http\Controllers\Controller;

class Reports extends Controller
{
    //Show overview of the statistics
    public function sales()
    {
        $sales_rep = SalesRep::select('first_name', 'last_name', 'repid')->get();
        $orders = Order::with('customer')->get();
        return view('Reports.sales', compact('orders',  'sales_rep'));
    }
    public function sales_per_rep(Request $request)
    {
        $sales_rep = SalesRep::select('first_name', 'last_name', 'repid')->get();
        $repid = $request->sales_person;
        if ($repid == 'Select Sales Person') {
            $orders = Order::with('customer')->get();
        } else {
            $orders = Order::with('customer')
                ->whereHas('customer', function ($query) use ($repid) {
                    $query->where('repid', $repid);
                })
                ->get();
            $rep = SalesRep::select('first_name', 'last_name')->where('repid', $repid)->get();
        }
        return view('Reports.sales', compact('orders', 'rep', 'sales_rep'));
    }
    public function products()
    {
        // $orderDetails = Order_detail::whereNotNull('product_id')->with('material')->get();

    }
    public function sales_allocations()
    {
        $allocations = DB::table('users_app')
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
            ->get();
        $sales_rep = User_app::where('user_type', 'SALES_REP')->get();
        return view('Reports.allocations', compact('sales_rep', 'allocations'));
    }

    public function allocations(Request $request)
    {
        if (isset($request->sales_person) && $request->sales_person !== null) {
            $allocations = DB::table('users_app')
                ->join('material_allocation', 'material_allocation.user_id', '=', 'users_app.user_id')
                ->join('material', 'material_allocation.material_id', '=', 'material.material_id')
                ->where('users_app.user_id', $request->sales_person)
                ->select(
                    'users_app.user_id',
                    'users_app.first_name',
                    'material.material_name',
                    'material_allocation.amount',
                    'material_allocation.allocation_id',
                    DB::raw("DATE_FORMAT(material_allocation.allocation_date, '%d-%m-%Y') AS allocation_date")
                )
                ->get();
        } else {
            $allocations = DB::table('users_app')
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
                ->get();
        };

        $sales_rep = User_app::where('user_type', 'SALES_REP')->get();
        $active_sales = User_app::where('user_id', $request->sales_person)->select('first_name', 'surname')->get();
        return view('Reports.allocations', compact('sales_rep', 'active_sales', 'allocations'));
    }
}
