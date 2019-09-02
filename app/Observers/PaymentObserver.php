<?php

namespace App\Observers;

use App\Models\Payment;

class PaymentObserver
{
    /**
     * Handle the payment "updating" event.
     * 
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function updating(Payment $payment){
        $existingPayment = Payment::withTrashed()->find($payment->id);

        if ( $existingPayment->isPayed() ) {
            abort(403, 'Cannot update registered payment');
        }
    }

   
    /**
     * Handle the payment "deleting" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function deleting(Payment $payment)
    {        
        $existingPayment = Payment::withTrashed()->find($payment->id);

        if ( $existingPayment->isPayed() ) {
            abort(403, 'Cannot delete registered payment');
        }
    }
}
