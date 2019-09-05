<?php

namespace App\Helpers;

use App\Models\Payment;

final class PaymentStatus {

    /**
     * @var Bool
     */
    protected $isPayed;


    public function __construct(Payment $payment) 
    {
        // always load existing payment from database
        $payment = Payment::withTrashed()->find($payment->id);

        $this->isPayed = $payment->isPayed();
    }

    
    /**
     * Determines if the payment can de deleted
     *
     * @return boolean
     */
    public function canBeDeleted() : bool {
        return $this->isPayed === false;
    }


    /**
     * Determines if the payment can de updated
     *
     * @return boolean
     */
    public function canBeUpdated() : bool {
        return $this->isPayed === false;
    }

    /**
     * Get the value of isPayed
     *
     * @return  Bool
     */ 
    public function getIsPayed() : bool
    {
        return $this->isPayed;
    }

}
