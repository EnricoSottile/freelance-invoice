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
     * @return bool
     */
    public function store(PaymentDto $request) : bool {
        $payment = new Payment();
        $payment->user_id = Auth::user()->id;
        
        foreach($this->attributes as $a) {
            $getter = 'get' . ucfirst($a);
            $payment[$a] = $request->$getter();
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
    public function update(PaymentDto $request, int $id) : bool {
        $payment = Payment::findOrFail($id);   
        
        foreach($this->attributes as $a) {
            $getter = 'get' . ucfirst($a);
            $payment[$a] = $request->$getter() ?? $payment[$a];
        }

        return $payment->save();
    }



}