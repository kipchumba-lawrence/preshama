<?php

use App\Http\Controllers\Reports;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LoginReportController;

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
Route::resource('profile', \App\Http\Controllers\Profile::class);
Route::resource('admin', \App\Http\Controllers\WardController::class);
Route::get('download/{id}', [\App\Http\Controllers\HomeController::class, 'download'])->name('download');

//approve orders by credit manager route
Route::post('unapproved', [\App\Http\Controllers\ApproveOrders::class, 'creditManagerApproval'])->name('creditManagerApproval');
Route::post('reverse', [\App\Http\Controllers\ApproveOrders::class, 'creditManagerReverse'])->name('creditManagerReverse');
Route::get('approved', [\App\Http\Controllers\ApproveOrders::class, 'ApprovedC'])->name('approved');


//approve orders by operations manager route
Route::post('save', [\App\Http\Controllers\ApproveOrders::class, 'operationsManagerApproval'])->name('operationsManagerApproval');
Route::post('reverseM', [\App\Http\Controllers\ApproveOrders::class, 'operationsManagerReverse'])->name('operationsManagerReverse');
Route::get('approved_by_credit_manager', [\App\Http\Controllers\ApproveOrders::class, 'ApprovedO'])->name('approvedByOm');

//allocations
Route::post('allocate', [\App\Http\Controllers\ApproveOrders::class, 'Allocate'])->name('procurementOfficerAllocate');
Route::get('allocated-materials', [\App\Http\Controllers\ApproveOrders::class, 'Allocated']);

//manage customers
Route::resource('customers', \App\Http\Controllers\CustomersController::class);

// Management Reports

// Sales
Route::get('report/sales', [Reports::class, 'sales'])->name('sales');
Route::post('report/sales', [Reports::class, 'sales_per_rep'])->name('sales_per_rep');
Route::get('/export-sales', [Reports::class, 'exportSales'])->name('export.orders');

// Allocation
Route::get('report/allocation', [Reports::class, 'sales_allocations'])->name('allocations');
Route::post('report/allocation', [Reports::class, 'allocations'])->name('allocationss_per_rep');
Route::get('/export-sales-allocations', [Reports::class, 'exportSalesAllocations'])->name('export.sales.allocations');


// Products
Route::get('report/products', [Reports::class, 'products_sold'])->name('products_sold');
Route::post('report/products', [Reports::class, 'products_sold_per_rep'])->name('products_sold_per_rep');
Route::get('/export-products-sold', [Reports::class, 'exportProductsSold'])->name('export.products.sold');


// Collections
Route::get('report/collections', [Reports::class, 'collections'])->name('collections');
Route::post('report/collections', [Reports::class, 'collections_per_rep'])->name('collections_per_rep');
Route::get('/export-collections', [Reports::class, 'exportCollections'])->name('export.collections');


// Login Reports
Route::get('login-audit', [LoginReportController::class, 'index'])->name('login-audit');
Route::get('/export-login-records', [LoginReportController::class, 'exportLoginRecords'])->name('export.login.records');

// Route::get('/sales/download', 'YourController@downloadSales')->name('sales.download');
