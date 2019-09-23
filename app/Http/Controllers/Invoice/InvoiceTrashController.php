<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \Auth;
use App\Models\Invoice;
use App\Http\Traits\DestroyAndRestore;


class InvoiceTrashController extends Controller
{

    /**
     * Show the trashed resource
     *
     * @param  int  $id
     * @return Invoice
     */
    public function show($id){
        $invoice = Auth::user()->invoices()->onlyTrashed()->findOrFail($id);
        return $invoice->toJson();
    }
    
    /**
     * StoresUploads
     */
    use DestroyAndRestore {
        restore as protected traitRestore;
        destroy as protected traitDestroy;
    }

    /**
     * Restores the file from trash
     *
     * @param Int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id){
        $invoice = Auth::user()->invoices()->onlyTrashed()->findOrFail($id);
        return $this->traitRestore($invoice);
    }


    /**
     * Completely deletes the file from trash
     *
     * @param Int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $invoice = Auth::user()->invoices()->onlyTrashed()->findOrFail($id);
        return $this->traitDestroy($invoice);
    }



}
