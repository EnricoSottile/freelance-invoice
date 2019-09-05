<?php

namespace App\Helpers;

use App\Models\Invoice;

final class InvoiceStatus {

    /**
     * @var Bool
     */
    protected $isRegistered;

    /**
     * @var Bool
     */
    protected $hasPayedPayments;

    /**
     * @var Bool
     */
    protected $hasUnpayedPayments;

    /**
     * @var Bool
     */
    protected $isTrashed;


    public function __construct(Invoice $invoice) 
    {
        // always load existing invoice from database
        $invoice = Invoice::withTrashed()->find($invoice->id);

        $this->isRegistered = $invoice->isRegistered();
        $this->hasPayedPayments = $invoice->payed_payments()->count() > 0;
        $this->hasUnpayedPayments = $invoice->unpayed_payments()->count() > 0;
        $this->isTrashed = $invoice->trashed();
    }

    
    /**
     * Determines if the invoice can de deleted
     *
     * @return boolean
     */
    public function canBeDeleted() : bool {
        return 
            $this->isRegistered === false && 
            $this->hasPayedPayments === false;
    }


    /**
     * Determines if the invoice can de updated
     *
     * @return boolean
     */
    public function canBeUpdated() : bool {
        return 
            $this->isRegistered === false && 
            $this->hasPayedPayments === false;
    }

    /**
     * Get the value of isRegistered
     *
     * @return  Bool
     */ 
    public function getIsRegistered() : bool
    {
        return $this->isRegistered;
    }

    /**
     * Get the value of hasPayedPayments
     *
     * @return  Bool
     */ 
    public function getHasPayedPayments() : bool
    {
        return $this->hasPayedPayments;
    }

    /**
     * Get the value of hasUnpayedPayments
     *
     * @return  Bool
     */ 
    public function getHasUnpayedPayments() : bool
    {
        return $this->hasUnpayedPayments;
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
