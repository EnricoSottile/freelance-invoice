<?php

namespace App\Services;

use \Auth;
use App\Models\Customer;

use App\Dto\CustomerDto;

final class CustomerService {

    
    protected $attributes = [
        'full_name', 
        'email', 
        'phone', 
        'vat_code'
    ];
    
    /**
     * store
     *
     * @param  mixed $request
     *
     * @return Customer
     */
    public function store(CustomerDto $request) : Customer {
        $customer = new Customer();
        $customer->user_id = Auth::user()->id;

        foreach($this->attributes as $a) {
            $getter = 'get' . ucfirst($a);
            $customer[$a] = $request->$getter();
        }

        $customer->save();
        return $customer;
    }



    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     *
     * @return Customer
     */
    public function update(CustomerDto $request, int $id) : Customer {
        $customer = Auth::user()->customers()->findOrFail($id);   
        
        foreach($this->attributes as $a) {
            $getter = 'get' . ucfirst($a);
            $customer[$a] = $request->$getter() ?? $customer[$a];
        }

        $customer->save();
        return $customer;
    }



}