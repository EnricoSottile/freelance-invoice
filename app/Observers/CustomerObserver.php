<?php

namespace App\Observers;

use App\Models\Customer;
use App\Helpers\CustomerStatus;

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
        $status = new CustomerStatus($customer);
                
        if ( $status->canBeDeleted() ) {
            // if is trashed, this 'deleting' is permanent, so remove all uploads
            $status->getIsTrashed() && $customer->deleteUploads();
            $status->getHasUnregisteredInvoices() && $customer->deleteUnregisteredInvoices();
        } else {
            abort(403, 'Customer cannot be deleted' );
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
        if( $customer->trashed_invoices()->count() ) {
            $customer->restoreTrashedInvoices();
        }
    }

}
