<?php

namespace App\Observers;

use App\Helpers\PaymentStatus;
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
        $status = new PaymentStatus($payment);
        
        if ( ! $status->canBeUpdated() ) {
            abort(403, 'Payment cannot be updated' );
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
        $status = new PaymentStatus($payment);


        if ( $status->canBeDeleted() ) {
            
            // if is trashed, this 'deleting' is permanent, so remove all uploads
            $status->getIsTrashed() && $payment->deleteUploads();

        } else {
            abort(403, 'Payment cannot be deleted' );
        }
        
    }
}
