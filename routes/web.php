<?php

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

Route::get('/', function () {
    return view('welcome');
});


// CUSTOMER
Route::resource('customer', 'CustomerController')
        ->only(['index', 'store', 'update', 'destroy']);

// INVOICE
Route::resource('invoice', 'InvoiceController')
        ->only(['index', 'store', 'update', 'destroy']);

// PAYMENT
Route::resource('payment', 'PaymentController')
        ->only(['index', 'store', 'update', 'destroy']);

        
// TRASH
Route::get('restore/{resource}/{id}', 'TrashController@restore')
        ->name('trash.restore');

Route::delete('trash/{resource}/{id}', 'TrashController@destroy')
        ->name('trash.destroy');