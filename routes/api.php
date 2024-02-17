<?php

use App\Http\Controllers\API;
use App\Http\Controllers\API\APICustomerController;
use App\Http\Controllers\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/auth', [Payment::class, 'auth_token']);
Route::get('/customer/{customer_id}', [API::class, 'getRegion']);
Route::get('/sales-rep-customers/{sales_rep_id}', [APICustomerController::class, 'getCustomersPerSalesRep']);
Route::middleware('api.key')->group(function () {
    Route::post('/stkPush',[Payment::class,'stkPushAPI']);
});
