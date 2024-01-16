<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Payment extends Controller
{
    public $authToken;
    public function initialToken()
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://sandbox.familybank.co.ke/connect/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'grant_type=client_credentials&client_id=Preshama&client_secret=secret&scope=ESB_REST_API',
                CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            dd($response);

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

    public function stkPush($orderID, $amount, $phone)
    {
        // The function to take in amount, phone number and order_ID
        $this->auth_token();
        $password = base64_encode("Preshama" . "1750017" . now()->format('YmdHis'));

        // STK Push Code
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.familybank.co.ke/api/v1/Mpesa/stkpush',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
  "AccountReference": "Test",
  "Amount": ' . $amount . ',
  "BusinessShortCode": "1750017",
  "CallBackUrl": "https://dev.preshamafeedsltd.com",
  "PartyA": "254727750214",
  "PartyB": "1750017",
  "Password": "' . $password . '",
  "PhoneNumber": "' . $phone . '",
  "ThirdPartyTransId": "' . $orderID . '",
  "Timestamp": "' . now()->format('YmdHis') . '",
  "TransactionDesc": "Payment for the purchase of goods.",
  "TransactionType": "CustomerPayBillOnline"
}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: text/any',
                'Authorization: Bearer ' . $this->authToken,
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }


    public function auth_token()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.familybank.co.ke/connect/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials&client_id=Preshama&client_secret=secret&scope=ESB_REST_API',
            CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $responseData = json_decode($response, true);
        $this->authToken = $responseData['access_token'];
    }


    public function stkPushAPI(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'orderID' => 'required',
            'amount' => 'required|numeric',
            'phone' => 'required|numeric',
        ]);

        // Retrieve validated input data
        $orderID = $request->input('orderID');
        $amount = $request->input('amount');
        $phone = $request->input('phone');

        // Your existing function code here

        $this->auth_token();
        $password = base64_encode("Preshama" . "1750017" . now()->format('YmdHis'));

        // STK Push Code
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.familybank.co.ke/api/v1/Mpesa/stkpush',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
  "AccountReference": "Test",
  "Amount": ' . $amount . ',
  "BusinessShortCode": "1750017",
  "CallBackUrl": "https://dev.preshamafeedsltd.com",
  "PartyA": "254727750214",
  "PartyB": "1750017",
  "Password": "' . $password . '",
  "PhoneNumber": "' . $phone . '",
  "ThirdPartyTransId": "' . $orderID . '",
  "Timestamp": "' . now()->format('YmdHis') . '",
  "TransactionDesc": "Payment for the purchase of goods.",
  "TransactionType": "CustomerPayBillOnline"
}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: text/any',
                'Authorization: Bearer ' . $this->authToken,
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;

        // Return the API response
        return response()->json(['message' => 'Request accepted for processing', 'orderID' => $orderID, 'amount' => $amount, 'phone' => $phone]);
    }




}
