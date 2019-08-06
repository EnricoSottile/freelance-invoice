<?php

namespace App\Services;

use \Auth;
use App\Dto\PaymentStoreDto;
use App\Dto\PaymentUpdateDto;
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
    public function store(PaymentStoreDto $request) : bool {
        $payment = new Payment();
        
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
    public function update(PaymentUpdateDto $request, int $id) : bool {
        $payment = Payment::findOrFail($id);   
        
        foreach($this->attributes as $a) {
            $getter = 'get' . ucfirst($a);
            $payment[$a] = $request->$getter() ?? $payment[$a];
        }

        return $payment->save();
    }



}