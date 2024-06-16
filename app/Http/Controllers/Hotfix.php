<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\UserApp;
use App\Models\Customer;
use App\Models\SalesRep;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class Hotfix extends Controller
{
    public function westCustomerRep()
    {
        $apiUrl = 'http://api.sajsoft.co.ke:96/api/customers/customers.php';
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        if ($response === false) {
            $errorMessage = 'Failed to fetch data from API';
            echo $errorMessage;
            Log::error($errorMessage);
            return response()->json(['error' => $errorMessage], 500);
        }

        try {
            $apiResponse = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON response from API');
            }

            $this->saveCustomers($apiResponse);
            $this->saveSalesReps($apiResponse);

            $successMessage = 'Data successfully fetched and saved';
            echo $successMessage;
            Log::info($successMessage);
            return response()->json(['success' => $successMessage]);
        } catch (Exception $e) {
            $errorMessage = 'Error: ' . $e->getMessage();
            echo $errorMessage;
            Log::error($errorMessage);
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    public function saveCustomers($apiResponse)
    {
        try {
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
                echo 'Customer ' . $data['name'] . ' saved successfully.' . PHP_EOL;
            }
            Log::info('Customers successfully saved');
        } catch (Exception $e) {
            $errorMessage = 'Error saving customers: ' . $e->getMessage();
            echo $errorMessage;
            Log::error($errorMessage);
            throw new Exception($errorMessage);
        }
    }

    public function saveSalesReps($apiResponse)
    {
        try {
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
                echo 'Sales rep ' . $rep['first_name'] . ' saved successfully.' . PHP_EOL;
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
                echo 'User app for sales rep ' . $salesRepName . ' saved successfully.' . PHP_EOL;
            }
            Log::info('Sales reps successfully saved');
        } catch (Exception $e) {
            $errorMessage = 'Error saving sales reps: ' . $e->getMessage();
            echo $errorMessage;
            Log::error($errorMessage);
            throw new Exception($errorMessage);
        }
    }

    public function West()
    {
        return $this->westCustomerRep();
    }

    public function fetchCategories()
    {
        $url = 'http://api.sajsoft.co.ke:96/api/categories/categories.php';

        // Perform the API request using Laravel's HTTP client
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->get($url);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch categories'], 500);
        }

        $data = $response->json();

        // Using DB transactions to ensure data integrity
        DB::transaction(function () use ($data) {
            foreach ($data as $row) {
                $material_group_code = $row['id'];
                $material_group_name = $row['category'];

                if (!empty($material_group_code)) {
                    // Call the stored procedure using DB::statement
                    DB::statement('CALL sp_material_group_insert(:p_material_group_code, :p_material_group_name)', [
                        'p_material_group_code' => $material_group_code,
                        'p_material_group_name' => $material_group_name,
                    ]);
                }
            }
        });

        return response()->json(['message' => 'Material groups fetched and inserted successfully']);
    }

    // Update products
    public function fetchProducts()
    {
        $url = 'http://api.sajsoft.co.ke:96/api/products/products.php';

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->get($url);

            if ($response->failed()) {
                $errorMessage = 'Failed to fetch data from API';
                echo $errorMessage;
                Log::error($errorMessage);
                return response()->json(['error' => $errorMessage], 500);
            }

            $data = $response->json();

            DB::beginTransaction();

            foreach ($data as $row) {
                $company_code = 'PRESHAMA';
                $material_type_code = null;
                $material_group_code = $row['category'];
                $material_no = $row['id'];
                $material_name = $row['description'];
                $uom = 'BAG';
                $net_weight = null;
                $net_weight_uom = null;
                $standard_price = $row['total_cost'];
                $moving_price = null;

                if (!empty($material_no)) {
                    DB::statement('CALL sp_material_insert(:p_company_code, :p_material_type_code, :p_material_group_code, :p_material_no, :p_material_name, :p_uom, :p_net_weight, :p_net_weight_uom, :p_standard_price, :p_moving_price)', [
                        'p_company_code' => $company_code,
                        'p_material_type_code' => $material_type_code,
                        'p_material_group_code' => $material_group_code,
                        'p_material_no' => $material_no,
                        'p_material_name' => $material_name,
                        'p_uom' => $uom,
                        'p_net_weight' => $net_weight,
                        'p_net_weight_uom' => $net_weight_uom,
                        'p_standard_price' => $standard_price,
                        'p_moving_price' => $moving_price,
                    ]);

                    echo 'Product ' . $material_name . ' saved successfully.' . PHP_EOL;
                }
            }

            DB::commit();

            $successMessage = 'Products fetched and saved successfully';
            echo $successMessage;
            Log::info($successMessage);
            return response()->json(['success' => $successMessage]);
        } catch (Exception $e) {
            DB::rollBack();
            $errorMessage = 'Error: ' . $e->getMessage();
            echo $errorMessage;
            Log::error($errorMessage);
            return response()->json(['error' => $errorMessage], 500);
        }
    }
    public function fetchCustomers()
    {
        $url = 'http://api.sajsoft.co.ke:96/api/customers/customers.php';

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->get($url);

            if ($response->failed()) {
                $errorMessage = 'Failed to fetch data from API';
                echo $errorMessage;
                Log::error($errorMessage);
                return response()->json(['error' => $errorMessage], 500);
            }

            $data = $response->json();

            DB::beginTransaction();

            foreach ($data as $row) {
                $customer_no = $row['id'];
                $customer_code = $row['code'];
                $customer_name = $row['name'];
                $credit_limit = $row['creditlimit'];
                $credit_exposure = $row['bal'];
                $mobileno = null;

                if (trim($customer_no) != '') {
                    DB::statement('CALL sp_customer_add(:p_customer_no, :p_customer_code, :p_customer_name, :p_credit_limit, :p_credit_exposure, :p_mobileno)', [
                        'p_customer_no' => $customer_no,
                        'p_customer_code' => $customer_code,
                        'p_customer_name' => $customer_name,
                        'p_credit_limit' => $credit_limit,
                        'p_credit_exposure' => $credit_exposure,
                        'p_mobileno' => $mobileno,
                    ]);

                    echo 'Customer ' . $customer_name . ' saved successfully.' . PHP_EOL;
                }
            }

            DB::commit();

            $successMessage = 'Customers fetched and saved successfully';
            echo $successMessage;
            Log::info($successMessage);
            return response()->json(['success' => $successMessage]);
        } catch (Exception $e) {
            DB::rollBack();
            $errorMessage = 'Error: ' . $e->getMessage();
            echo $errorMessage;
            Log::error($errorMessage);
            return response()->json(['error' => $errorMessage], 500);
        }
    }
}
