<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Payment;

use App\Http\Requests\StorePayment;
use App\Http\Requests\UpdatePayment;
use App\Services\PaymentService;

class PaymentController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Payment::all()->toJson();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePayment $request, PaymentService $paymentService)
    {        
        $paymentService->store( $request->getDto() );
        return response()->json();
    }

    /**
     * Show the resource
     *
     * @param  int  $id
     * @return Payment
     */
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return $payment->toJson();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePayment $request, PaymentService $paymentService, $id)
    {

        $paymentService->update( $request->getDto(), $id );
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
        $payment = Payment::findOrFail($id);  
        $payment->delete();
        return response()->json();
    }

}
