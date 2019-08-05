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
        $existingInvoice = Invoice::withTrashed()->findOrFail($invoice->id);

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
        
        $existingInvoice = Invoice::withTrashed()->findOrFail($invoice->id);
        if ( $existingInvoice->isRegistered() ) {
            throw new \Exception('Cannot delete registered invoice');
        }


        $hasPayedPayments = $invoice->received_payments()->count();
        if ($hasPayedPayments) {
            throw new \Exception('Cannot delete invoice with registered payments');
        }

    }

}
