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
        Route::resource('customer', 'Customer\CustomerController')
                ->only(['index', 'store', 'show', 'update', 'destroy']);
                
                // CUSTOMER INVOICES
                Route::get('customer/{customer}/invoice', 'Customer\CustomerInvoiceController@index')
                        ->name('customer.invoice.index');

                // CUSTOMER PAYMENTS
                Route::get('customer/{customer}/payment', 'Customer\CustomerPaymentController@index')
                        ->name('customer.payment.index');

                // CUSTOMER UPLOAD
                Route::get('customer/{customer}/upload', 'Customer\CustomerUploadController@index')
                        ->name('customer.upload.index');
                
                Route::post('customer/{customer}/upload', 'Customer\CustomerUploadController@store')
                        ->name('customer.upload.store');

                Route::delete('customer/{customer}/upload/{upload}', 'Customer\CustomerUploadController@destroy')
                        ->name('customer.upload.destroy');

                // CUSTOMER TRASH
                Route::get('customer/{customer}/restore', 'Customer\CustomerTrashController@restore')
                ->name('customer.trash.restore');
        
                Route::delete('customer/{customer}/destroy', 'Customer\CustomerTrashController@destroy')
                        ->name('customer.trash.destroy');



        // INVOICE
        Route::resource('invoice', 'Invoice\InvoiceController')
                ->only(['index', 'store', 'show', 'update', 'destroy']);

                // INVOICE UPLOAD
                Route::get('invoice/{invoice}/upload', 'Invoice\InvoiceUploadController@index')
                        ->name('invoice.upload.index');
                
                Route::post('invoice/{invoice}/upload', 'Invoice\InvoiceUploadController@store')
                        ->name('invoice.upload.store');

                Route::delete('invoice/{invoice}/upload/{upload}', 'Invoice\InvoiceUploadController@destroy')
                        ->name('invoice.upload.destroy');
        
                // INVOICE PAYMENTS
                Route::get('invoice/{invoice}/payment', 'Invoice\InvoicePaymentController@index')
                        ->name('invoice.payment.index');

                // INVOICE TRASH
                Route::get('invoice/{invoice}/restore', 'Invoice\InvoiceTrashController@restore')
                        ->name('invoice.trash.restore');
        
                Route::delete('invoice/{invoice}/destroy', 'Invoice\InvoiceTrashController@destroy')
                        ->name('invoice.trash.destroy');



        // PAYMENT
        Route::resource('payment', 'Payment\PaymentController')
                ->only(['index', 'store', 'show',  'update', 'destroy']);

                // PAYMENT UPLOAD
                Route::get('payment/{payment}/upload', 'Payment\PaymentUploadController@index')
                ->name('payment.upload.index');
                
                Route::post('payment/{payment}/upload', 'Payment\PaymentUploadController@store')
                        ->name('payment.upload.store');

                Route::delete('payment/{payment}/upload/{upload}', 'Payment\PaymentUploadController@destroy')
                        ->name('payment.upload.destroy');

                // PAYMENT TRASH
                Route::get('payment/{payment}/restore', 'Payment\PaymentTrashController@restore')
                        ->name('payment.trash.restore');
                
                Route::delete('payment/{payment}/destroy', 'Payment\PaymentTrashController@destroy')
                        ->name('payment.trash.destroy');


        //  UPLOAD
        Route::get('uploads/{upload}', 'UploadController@show')
                ->name('upload.show');

        Route::get('uploads/{upload}/download', 'UploadController@download')
                ->name('upload.download');


        // TRASH
        Route::get('trash', 'TrashController@index')
                ->name('trash.index');

        Route::get('trash/{resource}/{id}', 'TrashController@show')
                ->name('trash.show');

});

