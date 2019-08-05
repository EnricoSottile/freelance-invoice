<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

use App\Http\Requests\StoreCustomer;
use App\Http\Requests\UpdateCustomer;

class CustomerController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Customer::all()->toJson();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomer $request)
    {
        $attributes = ['full_name', 'email', 'phone', 'vat_code'];
        
        $customer = new Customer();
        foreach($attributes as $a) {
            $customer->{$a} = $request->{$a};
        }
        $customer->save();

        return response()->json();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomer $request, $id)
    {
        $customer = Customer::findOrFail($id);        
        $attributes = ['full_name', 'email', 'phone', 'vat_code'];

        foreach($attributes as $a) {
            $customer->{$a} = $request->{$a} ?? $customer->{$a};
        }

        $customer->save();

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);  
        $customer->delete();
        return response()->json();
    }

}
