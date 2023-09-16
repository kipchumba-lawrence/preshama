<?php

namespace App\Http\Controllers;

use app;
use App\Models\Order;
use App\Models\UserApp;
use App\Models\Customer;
use App\Models\SalesRep;
use App\Exports\OrderExport;

use App\Models\Order_detail;
use Illuminate\Http\Request;
use App\Exports\CollectionsExport;
use App\Exports\ProductSoldExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesAllocationExport;


class Reports extends Controller
{
    //Sales statistics 
    public function sales()
    {
        $sales_rep = DB::table('sales_person')
            ->select('first_name', 'last_name', 'repid')
            ->get();

        $orders = DB::table('order')
            ->join('customer', 'order.customer_id', '=', 'customer.customer_id')
            ->select('order.*', 'customer.*')
            ->get();
        // dd($orders);
        return view('Reports.sales', compact('orders', 'sales_rep'));
    }

    public function exportSales()
    {

        $orders = DB::table('order')
            ->join('customer', 'order.customer_id', '=', 'customer.customer_id')
            ->select('order.*', 'customer.*')
            ->get();
        return Excel::download(new OrderExport($orders), 'orders.xlsx');
    }

    public function sales_per_rep(Request $request)
    {
        $sales_rep = DB::table('sales_person')
            ->select('first_name', 'last_name', 'repid')
            ->get();

        $repid = $request->sales_person;
        if ($repid == 'Select Sales Person') {
            $orders = DB::table('order')
                ->join('customer', 'order.customer_id', '=', 'customer.customer_id')
                ->select('order.*', 'customer.*')
                ->get();
        } else {
            $orders = DB::table('order')
                ->join('customer', 'order.customer_id', '=', 'customer.customer_id')
                ->select('order.*', 'customer.*')
                ->where('customer.repid', $repid)
                ->get();

            $rep = DB::table('sales_person')
                ->select('first_name', 'last_name')
                ->where('repid', $repid)
                ->get();
        }

        session(['export_data' => $orders]);
        return view('Reports.sales', compact('orders', 'rep', 'sales_rep'));
    }


    // Allocations
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
        $sales_rep = UserApp::where('user_type', 'SALES_REP')->get();
        return view('Reports.allocations', compact('sales_rep', 'allocations'));
    }

    public function exportSalesAllocations()
    {
        return Excel::download(new SalesAllocationExport, 'sales_allocations.xlsx');
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

        $sales_rep = UserApp::where('user_type', 'SALES_REP')->get();
        $active_sales = UserApp::where('user_id', $request->sales_person)->select('first_name', 'surname')->get();
        return view('Reports.allocations', compact('sales_rep', 'active_sales', 'allocations'));
    }


    // Product Reports
    public function products_sold()
    {
        $sales_rep = SalesRep::select('first_name', 'last_name', 'repid')->get();
        $products = DB::table('order_detail')
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
            ->orderByDesc('order_detail.create_date')
            ->get();
        $count = $products->count();
        return view('Reports.products', compact('sales_rep', 'products', 'count'));
    }
    public function products_sold_per_rep(Request $request)
    {
        $repid = $request->sales_person;
        $products = DB::table('order_detail')
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
            ->where('sales_person.repid', '=', $repid)
            ->orderBy('order_detail.create_date', 'desc')
            ->get();

        $count = $products->count();
        $active_sales = SalesRep::where('repid', $repid)->select('first_name', 'last_name')->get();
        $sales_rep = SalesRep::select('first_name', 'last_name', 'repid')->get();
        return view('Reports.products', compact('sales_rep', 'products', 'active_sales', 'count'));
    }
    public function exportProductsSold()
    {
        return Excel::download(new ProductSoldExport, 'products_sold.xlsx');
    }

    // Collections
    public function collections()
    {
        $salesOrders = DB::table('order')
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
            ->groupBy('order.order_id', 'order.create_date', 'customer.customer_name', 'order.credit_manager_approval', 'order.operations_manager_approval', 'order.total_cost')
            ->get();
        $total_collections = $salesOrders->sum('total_cost');
        $sales_rep = SalesRep::select('first_name', 'last_name', 'repid')->get();
        return  view('Reports.collections', compact('total_collections', 'sales_rep', 'salesOrders'));
    }
    public function collections_per_rep(Request $request)
    {
        $repid = $request->sales_person;
        $salesOrders = DB::table('order')
            ->join('customer', 'order.customer_id', '=', 'customer.customer_id')
            ->join('sales_person', 'customer.repid', '=', 'sales_person.repid')
            ->select(
                'order.create_date',
                'customer.customer_name',
                'order.credit_manager_approval',
                'order.order_id',
                'order.total_cost',
                'order.operations_manager_approval',
                DB::raw('SUM(order.total_cost) as total_cost')
            )
            ->where('sales_person.repid', '=', $repid)
            ->groupBy('order.order_id', 'order.create_date', 'customer.customer_name', 'order.credit_manager_approval', 'order.operations_manager_approval', 'order.total_cost')
            ->get();

        $total_collections = $salesOrders->sum('total_cost');
        $sales_rep = SalesRep::select('first_name', 'last_name', 'repid')->get();
        $active_sales = SalesRep::where('repid', $repid)->select('first_name', 'last_name')->get();
        return view('Reports.collections', compact('total_collections', 'active_sales', 'sales_rep', 'salesOrders'));
    }
    public function exportCollections()
    {
        return Excel::download(new CollectionsExport, 'collections.xlsx');
    }
    // Update users
    public function refreshUsers()
    {
        // Get all UserApp records
        $users = UserApp::where('user_type', 'USER')->get();
        // Loop through each user and update the first_name field
        foreach ($users as $user) {

            // Retrieve the related customer record and update the first_name field in the UserApp table
            // $customer = Customer::find($user->customer_id);

            $customer = Customer::where('customer_id', $user->customer_id)->first();

            if ($customer) {
                // Assuming $user is the UserApp instance and $customer is the related Customer instance
                if ($customer) {
                    $nameParts = explode(' ', $customer->customer_name, 2); // Split customer_name into an array of parts (first word and the rest)

                    $user->first_name = $nameParts[0]; // Set first_name to the first word
                    $user->surname = isset($nameParts[1]) ? $nameParts[1] : null; // Set surname to the rest (if available)

                    $emailName = preg_replace("/[^a-zA-Z0-9]/", "", strtolower($customer->customer_name)); // Remove non-alphanumeric characters and convert to lowercase
                    $user->email = $emailName . "@preshama.com"; // Set the email

                    $user->save(); // Save the changes to the database
                }

                $user->save(); // Save the changes to the UserApp table
            }
        }
        $customers = Customer::all();
        return view('admin.customers.show', compact('customers'));
    }
    public function region_sales()
    {
        $orders = DB::table('order')
            ->join('customer', 'order.customer_id', '=', 'customer.customer_id')
            ->select('order.*', 'customer.*')
            ->get();
        // dd($orders);
        return view('Reports.region_sales', compact('orders'));
    }

    /**
     * Assigns a random region to each sales representative.
     **/
    public function assign()
    {
        $reps = SalesRep::all();

        foreach ($reps as $rep) {
            $region = rand(0, 1) ? 'East' : 'West'; // Randomly select East or West
            $rep->region = $region; // Assign the random region
            $rep->save(); // Save the record
        }

        return 'Regions updated randomly.';
    }
    public function sale_per_region(Request $request)
    {
        $region = $request->region; // Get the selected region

        if ($region == 'Select Region') {
            // Show orders for all regions (West and East)
            $orders = DB::table('order')
                ->join('customer', 'order.customer_id', '=', 'customer.customer_id')
                ->select('order.*', 'customer.*')
                ->get();
        } else {
            // Show orders for a specific region
            $orders = DB::table('order')
                ->join('customer', 'order.customer_id', '=', 'customer.customer_id')
                ->join('sales_person', 'customer.repid', '=', 'sales_person.repid')
                ->select('order.*', 'customer.*')
                ->where('sales_person.region', $region)
                ->get();
        }

        session(['export_data' => $orders]);
        return view('Reports.region_sales_per_rep', compact('orders','region'));
    }
}
