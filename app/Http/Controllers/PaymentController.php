<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Payment;

use App\Http\Requests\StorePayment;
use App\Http\Requests\UpdatePayment;

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
    public function store(StorePayment $request)
    {
        $attributes = [
            'invoice_id',
            'net_amount',
            'due_date',
            'payed_date',
        ];

        $payment = new Payment();

        foreach($attributes as $a) {
            $payment->{$a} = $request->{$a};
        }

        $payment->save();

        return response()->json();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePayment $request, $id)
    {
        $payment = Payment::findOrFail($id);     
        $attributes = [
            'invoice_id',
            'net_amount',
            'due_date',
            'payed_date',
        ];

        foreach($attributes as $a) {
            $payment->{$a} = $request->{$a} ?? $payment->{$a};
        }

        $payment->save();

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
