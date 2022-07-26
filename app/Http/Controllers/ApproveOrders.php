<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Order;
use App\Models\User;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApproveOrders extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //approved by credit manager
    public function approvedC(){
        $orders = Order::where('credit_manager',Auth::user()->user_id)->whereNull('operations_manager')->get();
        return view('creditmanager.approved',compact('orders'));
    }

    //approved by credit manager
    public function approvedO(){
        $orders = Order::where('operations_manager',Auth::user()->user_id)->get();
        return view('operationmanager.approved',compact('orders'));
    }

    public function creditManagerApproval(Request $request){

        if(!empty($request->orders)) {
            $order = implode(",", $request->orders);
//            Order::whereIn('order_id', [$parsed])->update(['credit_manager_approval' => 1]);
            $id = Auth::user()->user_id;
            $current_date_time = Carbon::now()->toDateTimeString();
            DB::statement( "UPDATE `order` SET `credit_manager_approval` = 1, `credit_manager` = $id, `credit_manager_approval_date` = '$current_date_time' WHERE `order_id` IN ($order)");
            return redirect()->back()->with('success',"Selected orders have been approved");
        }else{
            return redirect()->back()->with('error','No order selected');
        }

    }

    //reverse credit manager approval
    public function creditManagerReverse(Request $request){

        if(!empty($request->orders)) {
            $order = implode(",", $request->orders);
            DB::statement( "UPDATE `order` SET `credit_manager_approval` = NULL, `credit_manager` = NULL, `credit_manager_approval_date` = NULL WHERE `order_id` IN ($order)");
            return redirect()->back()->with('success',"Selected approvals have been reversed");
        }else{
            return redirect()->back()->with('error','No order selected');
        }

    }

    public function operationsManagerApproval(Request $request){

        if(!empty($request->orders)) {
            $order = implode(",", $request->orders);
//            Order::whereIn('order_id', [$parsed])->update(['credit_manager_approval' => 1]);
            $id = Auth::user()->user_id;
            $current_date_time = Carbon::now()->toDateTimeString();
            DB::statement( "UPDATE `order` SET `operations_manager_approval` = 1, `operations_manager` = $id, `operations_manager_approval_date` = '$current_date_time' WHERE `order_id` IN ($order)");
            return redirect()->back()->with('success',"Selected orders have been approved");
        }else{
            return redirect()->back()->with('error','No order selected');
        }

    }

    //reverse operations manager approval
    public function operationsManagerReverse(Request $request){

        if(!empty($request->orders)) {
            $order = implode(",", $request->orders);
            DB::statement( "UPDATE `order` SET `operations_manager_approval` = NULL, `operations_manager` = NULL, `operations_manager_approval_date` = NULL WHERE `order_id` IN ($order)");
            return redirect()->back()->with('success',"Selected approvals have been reversed");
        }else{
            return redirect()->back()->with('error','No order selected');
        }

    }


    //allocations
    public function Allocate(Request $request){
        if(!empty($request->materials)) {
            $materials = $request->materials;
            $amounts = $request->amounts;
//            $current_date_time = Carbon::now()->toDateTimeString();
            $current_date_time = Carbon::now();
            $user = $request->user;

            for($i=0; $i < count($materials); $i++){
                $data = [
                    'user_id'=>$user,
                    'material_id'=>$materials[$i],
                    'amount'=>$amounts[$i],
                    'allocation_date'=>$current_date_time
                ];
                DB::table('material_allocation')->insert($data);
            }

            return redirect()->back()->with('success',"Allocations completed successfully");
        }else{
            return redirect()->back()->with('error','No Material selected');
        }
    }

    public function Allocated(){
        if(Auth::user()->user_type=='Procurement Officer'){
            $materials = collect(DB::select("SELECT *,users.first_name as firstname, users.surname as surname FROM `material` INNER JOIN `users` INNER JOIN `material_allocation` WHERE material.material_id = material_allocation.material_id AND material_allocation.user_id = users.user_id"));
            return view('procurementofficer.allocated',compact('materials'));
        }else{
            return redirect()->route('home');
        }
    }
}
