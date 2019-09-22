<?php

namespace App\Observers;

use App\Helpers\InvoiceStatus;
use App\Models\Invoice;

class InvoiceObserver
{

    /**
     * Handle the invoice "updating" event.
     * 
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function updating(Invoice $invoice){
        $status = new InvoiceStatus($invoice);
        
        if ( ! $status->canBeUpdated() ) {
            abort(403, 'Invoice cannot be updated' );
        }
    }


    /**
     * Handle the invoice "restoring" event.
     * 
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function restoring(Invoice $invoice){        
        if ( $invoice->customer()->onlyTrashed()->count() ) {
            $invoice->customer()->onlyTrashed()->first()->restore();
        }
    }

   
    /**
     * Handle the invoice "deleting" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function deleting(Invoice $invoice)
    {        
        $status = new InvoiceStatus($invoice);
                
        if ( $status->canBeDeleted() ) {
            
            // if is trashed, this 'deleting' is permanent, so remove all uploads
            $status->getIsTrashed() && $invoice->deleteUploads();
            $status->getHasUnpayedPayments() && $invoice->deleteUnpayedPayments();

        } else {
            abort(403, 'Invoice cannot be deleted' );
        }
    }

}
