<?php

namespace App\Dto;

final class InvoiceDto
{

    protected $customer_id;
    protected $number;
    protected $net_amount;
    protected $tax;
    protected $description;
    protected $date;
    protected $sent_date;
    protected $registered_date;

    public function __construct(
        Int $customer_id,
        String $number,
        Float $net_amount,
        Float $tax,
        ?String $description,
        ?String $date,
        ?String $sent_date,
        ?String $registered_date
    ) {
        $this->customer_id = $customer_id;
        $this->number = $number;
        $this->net_amount = $net_amount;
        $this->tax = $tax;
        $this->description = $description;
        $this->date = $date;
        $this->sent_date = $sent_date;
        $this->registered_date = $registered_date;
    }


    /**
     * Get the value of customer_id
     */
    public function getCustomer_id() : Int
    {
        return $this->customer_id;
    }

    /**
     * Get the value of number
     */
    public function getNumber() : String
    {
        return $this->number;
    }

    /**
     * Get the value of net_amount
     */
    public function getNet_amount() : Float
    {
        return $this->net_amount;
    }

    /**
     * Get the value of tax
     */
    public function getTax() : Float
    {
        return $this->tax;
    }

    /**
     * Get the value of description
     */
    public function getDescription() : ?String
    {
        return $this->description;
    }

    /**
     * Get the value of date
     */
    public function getDate() : ?String
    {
        return $this->date;
    }

    /**
     * Get the value of sent_date
     */
    public function getSent_date() : ?String
    {
        return $this->sent_date;
    }

    /**
     * Get the value of registered_date
     */
    public function getRegistered_date() : ?String
    {
        return $this->registered_date;
    }
}
