<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Payment extends Controller
{
    public function auth_token()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'sandbox.familybank.co.ke:1045/connect/token',
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
            CURLOPT_HTTPHEADER => array(
                'Accept: */*',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        // Parse the JSON response and return it as a Laravel JSON response
        $responseData = json_decode($response, true);

        // Check if the JSON decoding was successful
        if ($responseData !== null) {
            return response()->json($responseData);
        } else {
            // If JSON decoding failed, return an error response
            return response()->json(['error' => 'Unable to parse the response'], 500);
        }
    }
}
