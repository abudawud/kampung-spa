<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('site', App\Http\Controllers\SiteController::class);
Route::resource('employee', App\Http\Controllers\EmployeeController::class);
Route::resource('customer', App\Http\Controllers\CustomerController::class);
Route::resource('item', App\Http\Controllers\ItemController::class);
Route::resource('package', App\Http\Controllers\PackageController::class);
