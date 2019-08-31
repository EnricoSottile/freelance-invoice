<?php

namespace App\Services;

use \Auth;
use App\Dto\PaymentDto;
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
     * @return Payment
     */
    public function store(PaymentDto $request) : Payment  {
        $payment = new Payment();
        $payment->user_id = Auth::user()->id;
        
        foreach($this->attributes as $a) {
            $getter = 'get' . ucfirst($a);
            $payment[$a] = $request->$getter();
        }

        $payment->save();

        return $payment;
    }



    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     *
     * @return bool
     */
    public function update(PaymentDto $request, int $id) : bool {
        $payment = Payment::findOrFail($id);   
        
        foreach($this->attributes as $a) {
            $getter = 'get' . ucfirst($a);
            $payment[$a] = $request->$getter() ?? $payment[$a];
        }

        return $payment->save();
    }



}