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


// custome route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/order/{order}/process', [App\Http\Controllers\OrderController::class, 'process'])->name('order.process');
Route::post('/order/{order}/process', [App\Http\Controllers\OrderController::class, 'process'])->name('order.process');
Route::get('/order/{order}/print-invoice', [App\Http\Controllers\OrderController::class, 'printInvoice'])->name('order.print-invoice');

// export routes
Route::get('/order/export', [App\Http\Controllers\OrderController::class, 'export'])->name('order.export');
Route::get('/customer-registration/export', [App\Http\Controllers\CustomerRegistrationController::class, 'export'])->name('customer-registration.export');

// json routes
Route::get('/customer/json', [App\Http\Controllers\CustomerController::class, 'json'])->name('customer.json');
Route::get('/employee/json', [App\Http\Controllers\EmployeeController::class, 'json'])->name('employee.json');
Route::get('/item/json', [App\Http\Controllers\ItemController::class, 'json'])->name('item.json');
Route::get('/package/json', [App\Http\Controllers\PackageController::class, 'json'])->name('package.json');

Route::resource('site', App\Http\Controllers\SiteController::class);
Route::resource('employee', App\Http\Controllers\EmployeeController::class);
Route::resource('customer', App\Http\Controllers\CustomerController::class);
Route::resource('item', App\Http\Controllers\ItemController::class);
Route::resource('package', App\Http\Controllers\PackageController::class);
Route::resource('order', App\Http\Controllers\OrderController::class);
Route::resource('order.order-package', App\Http\Controllers\OrderPackageController::class)->shallow();
Route::resource('order.order-item', App\Http\Controllers\OrderItemController::class)->shallow();
Route::resource('customer-registration', App\Http\Controllers\CustomerRegistrationController::class);
Route::resource('package.package-item', App\Http\Controllers\PackageItemController::class)->shallow()->except(['update', 'edit', 'show']);
