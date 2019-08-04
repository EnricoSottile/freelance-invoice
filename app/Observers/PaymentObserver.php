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
        $existingPayment = Payment::find($payment->id);

        if ( $existingPayment->isPayed() ) {
            throw new \Exception('Cannot update registered payment');
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
        $existingPayment = Payment::find($payment->id);

        if ( $existingPayment->isPayed() ) {
            throw new \Exception('Cannot delete registered payment');
        }
    }
}
