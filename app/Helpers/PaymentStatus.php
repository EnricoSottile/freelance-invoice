<?php

namespace App\Helpers;

use App\Models\Payment;

final class PaymentStatus {

    /**
     * @var Bool
     */
    protected $isPayed;


    /**
     * @var Bool
     */
    protected $isTrashed;


    public function __construct(Payment $payment) 
    {
        // always load existing payment from database
        $payment = Payment::withTrashed()->find($payment->id);

        $this->isPayed = $payment->isPayed();
        $this->isTrashed = $payment->trashed();
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


    /**
     * Get the value of isTrashed
     *
     * @return  Bool
     */ 
    public function getIsTrashed() : bool
    {
        return $this->isTrashed;
    }

}
