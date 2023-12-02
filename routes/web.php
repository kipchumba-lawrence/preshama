<?php

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\Reports;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Hotfix;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LoginReportController;

Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('users', UsersController::class);
Route::resource('profile', \App\Http\Controllers\Profile::class);
Route::resource('admin', \App\Http\Controllers\WardController::class);
Route::get('download/{id}', [HomeController::class, 'download'])->name('download');

// Approve orders by credit manager route
Route::post('unapproved', [\App\Http\Controllers\ApproveOrders::class, 'creditManagerApproval'])->name('creditManagerApproval');
Route::post('reverse', [\App\Http\Controllers\ApproveOrders::class, 'creditManagerReverse'])->name('creditManagerReverse');
Route::get('approved', [\App\Http\Controllers\ApproveOrders::class, 'ApprovedC'])->name('approved');

// Approve orders by operations manager route
Route::post('save', [\App\Http\Controllers\ApproveOrders::class, 'operationsManagerApproval'])->name('operationsManagerApproval');
Route::post('reverseM', [\App\Http\Controllers\ApproveOrders::class, 'operationsManagerReverse'])->name('operationsManagerReverse');
Route::get('approved_by_credit_manager', [\App\Http\Controllers\ApproveOrders::class, 'ApprovedO'])->name('approvedByOm');

// Allocations
Route::post('allocate', [\App\Http\Controllers\ApproveOrders::class, 'Allocate'])->name('procurementOfficerAllocate');
Route::get('allocated-materials', [\App\Http\Controllers\ApproveOrders::class, 'Allocated']);
Route::delete('delete-allocation{id}', [\App\Http\Controllers\ApproveOrders::class, 'deleteAllocation'])->name('deleteAllocation');

// Manage customers
Route::resource('customers', CustomersController::class);
Route::get('app-users/create', [CustomersController::class, 'create_app_user'])->name('customers.createAppUser');
Route::get('app-customers/create', [CustomersController::class, 'create_customer_user'])->name('customers.createCustomerUser');
Route::get('sales_rep', [CustomersController::class, 'index_sales'])->name('customers.showSalesRep');


Route::get('refresh-customers', [Reports::class, 'refreshUsers'])->name('refreshUsers');

// Management Reports
Route::get('report/sales', [Reports::class, 'sales'])->name('sales');
Route::post('report/sales', [Reports::class, 'sales_per_rep'])->name('sales_per_rep');
Route::get('/export-sales', [Reports::class, 'exportSales'])->name('export.orders');

Route::get('report/allocation', [Reports::class, 'sales_allocations'])->name('allocations');
Route::post('report/allocation', [Reports::class, 'allocations'])->name('allocationss_per_rep');
Route::get('/export-sales-allocations', [Reports::class, 'exportSalesAllocations'])->name('export.sales.allocations');

Route::get('report/products', [Reports::class, 'products_sold'])->name('products_sold');
Route::post('report/products', [Reports::class, 'products_sold_per_rep'])->name('products_sold_per_rep');
Route::get('/export-products-sold', [Reports::class, 'exportProductsSold'])->name('export.products.sold');

Route::get('report/collections', [Reports::class, 'collections'])->name('collections');
Route::post('report/collections', [Reports::class, 'collections_per_rep'])->name('collections_per_rep');
Route::get('/export-collections', [Reports::class, 'exportCollections'])->name('export.collections');

Route::get('login-audit', [LoginReportController::class, 'index'])->name('login-audit');
Route::get('/export-login-records', [LoginReportController::class, 'exportLoginRecords'])->name('export.login.records');

Route::get('report/region', [Reports::class, 'region_sales'])->name('region_sales');
Route::post('report/region', [Reports::class, 'sale_per_region'])->name('sale_per_region');
Route::get('report/assign', [Reports::class, 'assign']);

// Additional routes from the first file
Route::get('app-users', [CustomersController::class, 'index_app'])->name('customers.index_app');
Route::get('app-users/create', [CustomersController::class, 'create_app_user'])->name('customers.createAppUser');
Route::post('customers/update/appUser/{id}', [CustomersController::class, 'update_app_user'])->name('customers.update.appUser');
Route::post('users/update/User/{id}', [UsersController::class, 'update_user'])->name('users.update.user');

// Hotfix Routes
Route::get('update_customer_credit',[CustomersController::class, 'updateCustomersCredit'])->name('customers.update_customer_credit');
// TODO: Create routes to update the products and the clients
Route::get('system_update_west',[Hotfix::class, 'West'])->name('system_update_west');


