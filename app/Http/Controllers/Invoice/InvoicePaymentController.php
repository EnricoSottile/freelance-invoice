<?php

namespace App\Http\Controllers\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Invoice;

class InvoicePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Int $id)
    {
        $invoice = Invoice::findOrFail($id);
        return $invoice->payments()->get()->toJson();
    }
}
