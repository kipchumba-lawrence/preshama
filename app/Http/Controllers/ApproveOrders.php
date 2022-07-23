<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApproveOrders extends Controller
{
    public function creditManagerApproval(Request $request){

//        dd($request->orders);
        if(!empty($request->orders)) {
            $order = implode(",", $request->orders);
//            $parsed[] = (string)$order;
//            Order::whereIn('order_id', [$parsed])->update(['credit_manager_approval' => 1]);
            DB::statement( "UPDATE `order` SET `credit_manager_approval` = 1 WHERE `order_id` IN ($order)");
            return redirect()->back()->with('success',"Selected orders have been approved");
        }else{
            return redirect()->back()->with('error','No order selected');
        }


    }
}
