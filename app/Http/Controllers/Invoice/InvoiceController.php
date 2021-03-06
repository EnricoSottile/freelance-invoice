<?php

namespace App\Http\Controllers\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use \Auth;

use App\Http\Requests\StoreInvoice;
use App\Http\Requests\UpdateInvoice;
use App\Services\InvoiceService;


class InvoiceController extends Controller
{

    // used everywhere but index 
    // (because it's heavy on performance and not needed)
    protected $appends = ['is_editable', 'is_destroyable'];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()
            ->invoices()
            ->with('customer:id,full_name')
            ->get()
            ->toJson();
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
        $invoice->setAppends($this->appends);
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
        $invoice = Auth::user()->invoices()->findOrFail($id);
        return $invoice->setAppends($this->appends)->toJson();
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
        $invoice->setAppends($this->appends);
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
        $invoice = Auth::user()->invoices()->findOrFail($id);  
        $invoice->delete();
        return response()->json();
    }


}
