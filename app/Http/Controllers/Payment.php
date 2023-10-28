<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Payment extends Controller
{
public function auth_token()
{
    try {
        $curl = curl_init();

        $options = [
            CURLOPT_URL => 'https://sandbox.familybank.co.ke:1045/connect/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => '{
                "client_id": "Preshama",
                "client_secret": "secret",
                "grant_type": "client_credentials",
                "scope": "OB_BULK_PAY "
            }',
            CURLOPT_HTTPHEADER => [
                'Accept: */*',
                'Content-Type: application/json'
            ],
        ];

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);

        curl_close($curl);

        if ($response) {
            $responseData = json_decode($response, true);

            if ($responseData !== null) {
                return response()->json($responseData);
            } else {
                $errorMessage = 'Unable to parse the response';
                Log::channel('customlog')->error($errorMessage);
                return response()->json(['error' => $errorMessage], 500);
            }
        } else {
            $errorMessage = 'Empty response received from the API endpoint';
            Log::channel('customlog')->error($errorMessage);
            return response()->json(['error' => $errorMessage], 500);
        }
    } catch (\Exception $e) {
        $errorMessage = 'An error occurred during the token authentication: ' . $e;
        Log::channel('customlog')->error($errorMessage);
        Log::channel('customlog')->error($e);
        return response()->json(['error' => 'An error occurred during the token authentication.'], 500);
    }
}
}
