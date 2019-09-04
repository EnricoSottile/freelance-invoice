<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use \Auth;

use App\Http\Requests\StoreInvoice;
use App\Http\Requests\UpdateInvoice;
use App\Services\InvoiceService;


class InvoiceController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Invoice::all()->toJson();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoice $request, InvoiceService $invoiceService)
    {
        $invoice = $invoiceService->store( $request->getDto() );
        return response()->json(['invoice' => $invoice]);
    }



    /**
     * Show the resource
     *
     * @param  int  $id
     * @return Invoice
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return $invoice->toJson();
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoice $request, InvoiceService $invoiceService, $id)
    {
        $invoice = $invoiceService->update( $request->getDto(), $id );
        return response()->json(['invoice' => $invoice]);
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
