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
        $canBeDestroyed = $customer->canBeDestroyed();
        if ($canBeDestroyed === false) {
            abort(403, 'This customer cannot be deleted');
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
