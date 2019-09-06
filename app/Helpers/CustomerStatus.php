<?php

namespace App\Helpers;

use App\Models\Customer;

final class CustomerStatus {


    /**
     * @var Bool
     */
    protected $hasRegisteredInvoices;

    /**
     * @var Bool
     */
    protected $hasUnregisteredInvoices;

    /**
     * @var Bool
     */
    protected $hasPayedPayments;


    public function __construct(Customer $customer) 
    {
        // always load existing customer from database
        $customer = Customer::withTrashed()->find($customer->id);

        $this->hasRegisteredInvoices = $customer->registered_invoices()->count() > 0;
        $this->hasUnregisteredInvoices = $customer->unregistered_invoices()->count() > 0;
        $this->hasPayedPayments = $customer->payed_payments()->count() > 0;
    }

    
    /**
     * Determines if the customer can de deleted
     *
     * @return boolean
     */
    public function canBeDeleted() : bool {
        return 
            ! $this->hasRegisteredInvoices &&
            ! $this->hasPayedPayments;
    }



    
 

    /**
     * Get the value of hasRegisteredInvoices
     *
     * @return  Bool
     */ 
    public function getHasRegisteredInvoices()
    {
        return $this->hasRegisteredInvoices;
    }

    /**
     * Get the value of hasUnregisteredInvoices
     *
     * @return  Bool
     */ 
    public function getHasUnregisteredInvoices()
    {
        return $this->hasUnregisteredInvoices;
    }

    /**
     * Get the value of hasPayedPayments
     *
     * @return  Bool
     */ 
    public function getHasPayedPayments()
    {
        return $this->hasPayedPayments;
    }
}
