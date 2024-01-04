<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Customer;
use App\Models\SalesRep;
use App\Models\UserApp;

class Hotfix extends Controller
{


    function westCustomerRep()
    {
        $apiUrl = 'http://api.sajsoft.co.ke:96/api/customers/customers.php';
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        try {
            $apiResponse = json_decode($response, true);
            $this->saveCustomers($apiResponse);
            $this->saveSalesReps($apiResponse);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
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
            // Save to the user_app model with the correct creds
        }
    }

    function saveSalesReps($apiResponse)
    {
        // Handles west side
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

        // Update or create SalesRep records
        $data->each(function ($rep) {
            SalesRep::updateOrCreate(
                ['repid' => $rep['repid']],
                [
                    'first_name' => $rep['first_name'],
                    'region' => $rep['region'],
                ]
            );
        });

        // Save to the user_app model with the correct creds
        foreach ($uniqueReps as $salesRepName => $repid) {
            $username = str_replace(' ', '', $salesRepName) . '@preshama.com';
            UserApp::updateOrCreate(
                ['username' => $username],
                [
                    'first_name' => $salesRepName,
                    'pin' => '0',
                    'email' => $username,
                    'user_type' => 'SALES_REP',
                    'region' => 'West',
                    'mobileno' => '-',
                ]
            );
        }
    }




    public function West()
    {
        return $this->westCustomerRep();
    }
    public function East()
    {
    }
}
