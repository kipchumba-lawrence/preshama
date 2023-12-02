<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Payment extends Controller
{
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
                CURLOPT_HTTPHEADER => array(    'Content-Type: application/x-www-form-urlencoded'  ),));
                $response = curl_exec($curl);curl_close($curl);
                
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

public function stkPush(){
    $this->authToken();

    // STK Push Code
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'sandbox.familybank.co.ke:1044/api/v1/Mpesa/stkpush',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "AccountReference": "Test",
  "Amount": "10",
  "BusinessShortCode": "222111",
  "CallBackUrl": "https://dev.preshamafeedsltd.com",
  "PartyA": "254727750214",
  "PartyB": "222111",
  "Password": "<string>",
  "PhoneNumber": "254727750214",
  "ThirdPartyTransId": "Order0080",
  "Timestamp": "<string>",
  "TransactionDesc": "Payment for the purchase of goods.",
  "TransactionType": "CustomerPayBillOnline"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Accept: text/plain',
    'Authorization: Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6IjU2YzcwMjVmMjg4YTBlYWI1NDdmYTY2YmZlNDMwNTUzIiwidHlwIjoiSldUIn0.eyJuYmYiOjE2OTk5NTkzNjIsImV4cCI6MTY5OTk2Mjk2MiwiaXNzIjoiaHR0cHM6Ly9zYW5kYm94LmZhbWlseWJhbmsuY28ua2UiLCJhdWQiOlsiaHR0cHM6Ly9zYW5kYm94LmZhbWlseWJhbmsuY28ua2UvcmVzb3VyY2VzIiwiRVNCX1JFU1RfQVBJIl0sImNsaWVudF9pZCI6IlByZXNoYW1hIiwic2NvcGUiOlsiRVNCX1JFU1RfQVBJIl19.Yu90DM-7GsDqQ_vz3OqTN4pmIt_t1KjKStzs1QIGrtJpTKb3YOqPpYjs-DFYTmxTTtH-logN5WnVG7po02i6CWTgIbc2eWeDIkxEa_rwKx0RMWxX1ejaKUYWayk1HQQRYKFKkGvK_UmlNa0pv9uvMZmTLOrGsiXPxTyF33NaQ_EcXz4zsGBjSFK5S3Pgt7RcZJPebU7Ig1efxe13BSB9J6N2i3Ud9Iiyb-0mh9JYglTGyoUWS0CHShMsrMK3ZEkMZua8dhiFQe_tCmSfbXEZ6mBWC-puMqVRabU-leG-yrJclEawqpSnTTeDupSKviLg463w-qenvUDHbBMGIK26rg'
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
        CURLOPT_HTTPHEADER => array(    'Content-Type: application/x-www-form-urlencoded'  ),));
        $response = curl_exec($curl);curl_close($curl);
        $responseData = json_decode($response, true);
        dd($responseData['access_token']);
}}
