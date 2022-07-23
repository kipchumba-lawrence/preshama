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
