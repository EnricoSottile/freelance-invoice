<?php

namespace App\Services;

use \Auth;
use App\Models\Payment;

final class PaymentService {

    
    protected $attributes = [
        'invoice_id',
        'net_amount',
        'due_date',
        'payed_date',
    ];

    
    /**
     * store
     *
     * @param  mixed $request
     *
     * @return bool
     */
    public function store(Array $request) : bool {
        $payment = new Payment();
        
        foreach($this->attributes as $a) {
            $payment[$a] = $request[$a];
        }

        return $payment->save();
    }



    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     *
     * @return bool
     */
    public function update(Array $request, int $id) : bool {
        $payment = Payment::findOrFail($id);   
        
        foreach($this->attributes as $a) {
            $payment[$a] = $request[$a] ?? $payment[$a];
        }

        return $payment->save();
    }



}