<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Customer;
use App\Models\SalesRep;
use Illuminate\Http\Request;

class Hotfix extends Controller
{


    function westCustomerRep()
    {
        $apiUrl = 'http://api.sajsoft.co.ke:96/api/customers/customers.php';
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        try {
            $apiResponse = json_decode($response, true);
            $this->saveCustomers($apiResponse);
            $this->saveSalesReps($apiResponse);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        curl_close($ch);
    }
    function saveCustomers($apiResponse)
    {
        foreach ($apiResponse as $data) {
            Customer::updateOrCreate(
                ['customer_code' => $data['code']],
                [
                    'customer_name' => $data['name'],
                    'customer_no' => $data['id'],
                    'credit_limit' => $data['creditlimit'],
                    'credit_exposure' => $data['bal'],
                    'repid' => $data['repid'],
                    'salesrep' => $data['salesrep'],
                    'region_id' => $data['region_id'],
                    'route' => $data['route'],
                ]
            );
        }
    }

function saveSalesReps($apiResponse)
{
    $uniqueReps = collect($apiResponse)
        ->pluck('repid', 'salesrep')
        ->unique();

    $data = $uniqueReps->map(function ($repid, $salesRepName) {
        return [
            'repid' => $repid,
            'first_name' => $salesRepName,
            'region' => 'West',
        ];
    });

    SalesRep::upsert($data->toArray(), ['repid'], ['first_name', 'region']);
}


    public function West()
    {
        return $this->westCustomerRep();
    }
    public function East()
    {
    }
}
