<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

use App\Http\Requests\StoreCustomer;
use App\Http\Requests\UpdateCustomer;
use App\Services\CustomerService;
use \Auth;

class CustomerController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()->customers()->get()->toJson();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomer $request, CustomerService $customerService)
    {        
        $customer = $customerService->store( $request->getDto() );
        return response()->json(['customer' => $customer]);
    }


    /**
     * Show the resource
     *
     * @param  int  $id
     * @return Customer
     */
    public function show($id)
    {
        $customer = Auth::user()->customers()->findOrFail($id);
        return $customer->toJson();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomer $request, CustomerService $customerService, $id)
    {
        $customer = $customerService->update( $request->getDto(), $id );
        return response()->json(['customer' => $customer]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Auth::user()->customers()->findOrFail($id);  
        $customer->delete();
        return response()->json();
    }

}
