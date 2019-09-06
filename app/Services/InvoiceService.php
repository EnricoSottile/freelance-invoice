<?php

namespace App\Services;

use \Auth;
use App\Models\Invoice;
use App\Dto\InvoiceDto;

final class InvoiceService {

    
    protected $attributes = [
        'customer_id',
        'number',
        'net_amount',
        'tax',
        'description',
        'date',
        'sent_date',
        'registered_date'
    ];

    
    /**
     * store
     *
     * @param  mixed $request
     *
     * @return Invoice
     */
    public function store(InvoiceDto $request) : Invoice {

        $invoice = new Invoice();
        $invoice->user_id = Auth::user()->id;

        foreach($this->attributes as $a) {
            $getter = 'get' . ucfirst($a);
            $invoice[$a] = $request->$getter();
        }

        $invoice->save();
        return $invoice;
    }



    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     *
     * @return Invoice
     */
    public function update(InvoiceDto $request, int $id) : Invoice {
        $invoice = Auth::user()->invoices()->findOrFail($id);   
        
        foreach($this->attributes as $a) {
            $getter = 'get' . ucfirst($a);
            $invoice[$a] = $request->$getter() ?? $invoice[$a];
        }

        $invoice->save();
        return $invoice;
    }



}