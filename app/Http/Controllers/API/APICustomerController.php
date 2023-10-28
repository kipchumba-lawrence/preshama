<?php

namespace App\Http\Controllers\API;


use App\Models\Customer;
use App\Http\Controllers\Controller;

class APICustomerController extends Controller
{
    public function getCustomersPerSalesRep($sales_rep_id){
        $customers=Customer::where('repid',$sales_rep_id)->get();
        return response()->json($customers);
    }
}
