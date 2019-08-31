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


// Route::middleware(['auth'])->group(function () {
Route::prefix('app')->middleware(['web', 'auth'])->group(function () {

        // TODO
        \Auth::loginUsingId(1);

        // CUSTOMER
        Route::resource('customer', 'CustomerController')
                ->only(['index', 'store', 'show', 'update', 'destroy']);
                
                // CUSTOMER INVOICES
                Route::get('customer/{customer}/invoice', 'CustomerInvoiceController@index')
                        ->name('customer.invoice.index');



        // INVOICE
        Route::resource('invoice', 'InvoiceController')
                ->only(['index', 'store', 'show', 'update', 'destroy']);

                // INVOICE PAYMENTS
                Route::get('invoice/{invoice}/payment', 'InvoicePaymentController@index')
                        ->name('invoice.payment.index');



        // PAYMENT
        Route::resource('payment', 'PaymentController')
                ->only(['index', 'store', 'show',  'update', 'destroy']);


        // TRASH
        Route::get('trash/restore/{resource}/{id}', 'TrashController@restore')
                ->name('trash.restore');

        Route::delete('trash/destroy/{resource}/{id}', 'TrashController@destroy')
                ->name('trash.destroy');


});

