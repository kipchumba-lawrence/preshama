<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class API extends Controller
{
 /**
  * Retrieve the region based on the customer_id and repid.
  *
  * @param int $customer_id The ID of the customer.
  * @throws Some_Exception_Class Description of the exception.
  * @return \Illuminate\Http\JsonResponse The JSON response containing the customer ID and region if successful, or an error JSON response if the customer is not found.
  */
 public function getRegion($customer_id)
    {
        $region = DB::table('customer')
            ->where('customer_id', $customer_id)
            ->join('sales_person', 'customer.repid', '=', 'sales_person.repid')
            ->value('sales_person.region');

        if ($region) {
            $data = [
                'customer_id' => $customer_id,
                'region' => $region,
            ];
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Customer not found'], 404);
        }
    }
}