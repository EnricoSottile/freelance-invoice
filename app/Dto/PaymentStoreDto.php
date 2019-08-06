<?php

namespace App\Dto;

final class PaymentStoreDto {
    
    protected $invoice_id;
    protected $net_amount;
    protected $due_date;
    protected $payed_date;

    public function __construct(
        Int $invoice_id, 
        Float $net_amount, 
        ? String $due_date, 
        ? String $payed_date
        )
    {
        $this->invoice_id = $invoice_id;
        $this->net_amount = $net_amount;
        $this->due_date = $due_date;
        $this->payed_date = $payed_date;
    }


        /**
         * Get the value of invoice_id
         */ 
        public function getInvoice_id() : Int
        {
                return $this->invoice_id;
        }

        /**
         * Get the value of net_amount
         */ 
        public function getNet_amount() : Float
        {
                return $this->net_amount;
        }

        /**
         * Get the value of due_date
         */ 
        public function getDue_date() : ? String
        {
                return $this->due_date;
        }

        /**
         * Get the value of payed_date
         */ 
        public function getPayed_date() : ? String
        {
                return $this->payed_date;
        }
}