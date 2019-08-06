<?php

namespace App\Services;

use \Auth;
use App\Models\Customer;

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
     * @return bool
     */
    public function store(Array $request) : bool {
        $customer = new Customer();

        foreach($this->attributes as $a) {
            $customer[$a] = $request[$a];
        }

        return $customer->save();
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
        $customer = Customer::findOrFail($id);   
        
        foreach($this->attributes as $a) {
            $customer[$a] = $request[$a] ?? $customer[$a];
        }

        return $customer->save();
    }



}