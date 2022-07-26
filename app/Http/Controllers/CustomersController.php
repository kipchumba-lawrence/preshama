<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Route;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->user_type=='Admin'){
            $customers = Customer::all();
            return view('admin.customers.show',compact('customers'));
        }else{
            return redirect()->route('home');
        }
    }


    public function create()
    {
       if(Auth::user()->user_type=='Admin'){
           $sales_managers = User::where('user_type','Sales Manager')->get();
           $routes = Route::all();
           return view('admin.customers.create',compact('sales_managers','routes'));
       }else{
           return redirect()->route('home');
       }
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:100',
            'salesmanager'=>'required',
            'route'=>'required',
            'customer_number'=>'required'
        ]);

        $customer = new Customer();
        $customer->customer_name = $request->name;
        $customer->customer_no = $request->customer_number;
        $customer->customer_code = $request->customer_code;
        $customer->email = $request->email;
        $customer->mobileno = $request->mobile;
        $customer->credit_limit = $request->credit_exposure;
        $customer->credit_exposure = $request->credit_exposure;
        $customer->save();
        $customer->salesman()->syncWithPivotValues([$request->salesmanager],['route_id'=>$request->route]);

        return redirect()->back()->with('success',"$request->name successfully registered");

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('admin.customers.edit',compact('customer'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $customer = Customer::where('customer_id',$id)->first();
        $customer->delete();
        $customer->salesman()->detach();
        return redirect()->back()->with('success',"Successfully deleted");
    }
}
