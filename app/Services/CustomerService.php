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
     * @return bool
     */
    public function store(CustomerDto $request) : bool {
        $customer = new Customer();

        foreach($this->attributes as $a) {
            $getter = 'get' . ucfirst($a);
            $customer[$a] = $request->$getter();
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
    public function update(CustomerDto $request, int $id) : bool {
        $customer = Customer::findOrFail($id);   
        
        foreach($this->attributes as $a) {
            $getter = 'get' . ucfirst($a);
            $customer[$a] = $request->$getter() ?? $customer[$a];
        }

        return $customer->save();
    }



}