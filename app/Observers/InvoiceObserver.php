<?php

namespace App\Observers;

use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;

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
        $existingInvoice = Invoice::withTrashed()->find($invoice->id);

        if ( $existingInvoice->isRegistered() ) {
            abort(403, 'Cannot update registered invoice');
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
        $existingInvoice = Invoice::withTrashed()->find($invoice->id);

        if ( $existingInvoice->isRegistered() ) {
            abort(403, 'Cannot delete registered invoice');
        }

        
        $hasPayedPayments = $existingInvoice->payed_payments()->count();
        $hasUnpayedPayments = $existingInvoice->unpayed_payments()->count();
        if ($hasPayedPayments) {
            abort(403, 'Cannot delete invoice with payed payments');
        } elseif($hasUnpayedPayments) {
            $invoice->unpayed_payments()->each(function($p) {
                $p->delete();
            });
        }

        
        if ($invoice->trashed()) {
        // Im deleting permanently therefore remove uploads
            $invoice->uploads()->each(function($upload){
                Storage::delete($upload->path);
                $upload->delete();
            });
        }


    }

}
