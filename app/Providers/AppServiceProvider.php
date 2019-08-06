<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Customer;
use App\Observers\CustomerObserver;

use App\Models\Invoice;
use App\Observers\InvoiceObserver;

use App\Models\Payment;
use App\Observers\PaymentObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Customer::observe(CustomerObserver::class);
        Invoice::observe(InvoiceObserver::class);
        Payment::observe(PaymentObserver::class);
    }
}
