<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('users', \App\Http\Controllers\UsersController::class);
Route::resource('profile',\App\Http\Controllers\Profile::class);
Route::resource('admin',\App\Http\Controllers\WardController::class);
Route::get('download/{id}',[\App\Http\Controllers\HomeController::class, 'download'])->name('download');

//approve orders by credit manager route
Route::post('unapproved',[\App\Http\Controllers\ApproveOrders::class, 'creditManagerApproval'])->name('creditManagerApproval');
Route::post('reverse',[\App\Http\Controllers\ApproveOrders::class, 'creditManagerReverse'])->name('creditManagerReverse');
Route::get('approved',[\App\Http\Controllers\ApproveOrders::class, 'ApprovedC'])->name('approved');


//approve orders by operations manager route
Route::post('save',[\App\Http\Controllers\ApproveOrders::class, 'operationsManagerApproval'])->name('operationsManagerApproval');
Route::post('reverseM',[\App\Http\Controllers\ApproveOrders::class, 'operationsManagerReverse'])->name('operationsManagerReverse');
Route::get('approved_by_credit_manager',[\App\Http\Controllers\ApproveOrders::class, 'ApprovedO'])->name('approvedByOm');

//allocations
Route::post('allocate',[\App\Http\Controllers\ApproveOrders::class,'Allocate'])->name('procurementOfficerAllocate');
Route::get('allocated-materials',[\App\Http\Controllers\ApproveOrders::class,'Allocated']);

//manage customers
Route::resource('customers', \App\Http\Controllers\CustomersController::class);

