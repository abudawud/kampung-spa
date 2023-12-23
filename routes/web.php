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
// redirect access to root path
Route::get('/', function () {
    return redirect('/home');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// export routes
Route::get('/order/export', [App\Http\Controllers\OrderController::class, 'export'])->name('order.export');
Route::get('/customer-registration/export', [App\Http\Controllers\CustomerRegistrationController::class, 'export'])->name('customer-registration.export');


Route::resource('site', App\Http\Controllers\SiteController::class);
Route::resource('employee', App\Http\Controllers\EmployeeController::class);
Route::resource('customer', App\Http\Controllers\CustomerController::class);
Route::resource('item', App\Http\Controllers\ItemController::class);
Route::resource('package', App\Http\Controllers\PackageController::class);
Route::resource('order', App\Http\Controllers\OrderController::class);
Route::resource('customer-registration', App\Http\Controllers\CustomerRegistrationController::class);
