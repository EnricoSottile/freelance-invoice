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
     * @return bool
     */
    public function store(InvoiceDto $request) : bool {

        $invoice = new Invoice();
        $invoice->user_id = Auth::user()->id;

        foreach($this->attributes as $a) {
            $getter = 'get' . ucfirst($a);
            $invoice[$a] = $request->$getter();
        }

        return $invoice->save();
    }



    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     *
     * @return bool
     */
    public function update(InvoiceDto $request, int $id) : bool {
        $invoice = Invoice::findOrFail($id);   
        
        foreach($this->attributes as $a) {
            $getter = 'get' . ucfirst($a);
            $invoice[$a] = $request->$getter() ?? $invoice[$a];
        }

        return $invoice->save();
    }



}