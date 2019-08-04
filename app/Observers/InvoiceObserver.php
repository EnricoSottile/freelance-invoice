<?php

namespace App\Observers;

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
        $existingInvoice = Invoice::find($invoice->id);

        if ( $existingInvoice->isRegistered() ) {
            throw new \Exception('Cannot update registered invoice');
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
        $existingInvoice = Invoice::find($invoice->id);

        if ( $existingInvoice->isRegistered() ) {
            throw new \Exception('Cannot delete registered invoice');
        }
    }

}
