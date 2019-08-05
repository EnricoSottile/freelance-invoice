<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use \Auth;

use App\Http\Requests\StoreInvoice;
use App\Http\Requests\UpdateInvoice;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Invoice::all()->toJson();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoice $request)
    {
        $attributes = [
            'customer_id',
            'number',
            'net_amount',
            'tax',
            'description',
            'date',
            'sent_date',
            'registered_date',
        ];


        $invoice = new Invoice();
        $invoice->user_id = Auth::user()->id;

        foreach($attributes as $a) {
            $invoice->{$a} = $request->{$a};
        }

        $invoice->save();

        return response()->json();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoice $request, $id)
    {
        $invoice = Invoice::findOrFail($id);     
        $attributes = [
            'customer_id',
            'number',
            'net_amount',
            'tax',
            'description',
            'date',
            'sent_date',
            'registered_date',
        ];

        foreach($attributes as $a) {
            $invoice->{$a} = $request->{$a} ?? $invoice->{$a};
        }

        $invoice->save();

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
        $invoice = Invoice::findOrFail($id);  
        $invoice->delete();
        return response()->json();
    }

}
