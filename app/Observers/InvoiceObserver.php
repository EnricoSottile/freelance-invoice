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
        if ( $invoice->isRegistered() ) {
            throw new \Exception('Cannot update registered invoice');
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
        $trashedPayments = $invoice->trashed_payments();
        if( $trashedPayments->count() ) {
            $trashedPayments->each(function($p) {
                $p->restore();
            });
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

        if ( $invoice->isRegistered() ) {
            throw new \Exception('Cannot delete registered invoice');
        }

        
        $hasPayedPayments = $invoice->payed_payments()->count();
        $hasUnpayedPayments = $invoice->unpayed_payments()->count();
        if ($hasPayedPayments) {
            throw new \Exception('Cannot delete invoice with payed payments');
        } elseif($hasUnpayedPayments) {
            $invoice->unpayed_payments()->each(function($p) {
                $p->delete();
            });
        }


    }

}
