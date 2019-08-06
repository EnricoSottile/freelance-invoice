<?php

namespace App\Observers;

use App\Models\Customer;

class CustomerObserver
{


    /**
     * Handle the customer "deleting" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function deleting(Customer $customer)
    {
        $hasRegisteredInvoices = $customer->registered_invoices()->count();
        if ($hasRegisteredInvoices) {
            throw new \Exception('Cannot delete customer with registered invoices');
        }

        $hasPayedPayments = $customer->payed_payments()->count();
        if ($hasPayedPayments) {
            // The problem here is that an invoice can be payed 
            // even if it has not been registered yet,
            // therefore payed payment can exists without a registered invoice
            throw new \Exception('Cannot delete customer with payed payments');
        }

        $hasUnregisteredInvoices = $customer->unregistered_invoices()->count();
        if ($hasUnregisteredInvoices) {
            $customer->unregistered_invoices()->each(function($inv) {
                $inv->delete();
            });
        }
    }

    /**
     * Handle the customer "restoring" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function restoring(Customer $customer)
    {
        $trashedInvoices = $customer->trashed_invoices();
        if( $trashedInvoices->count() ) {
            $trashedInvoices->each(function($inv) {
                $inv->restore();
            });
        }
    }

}
