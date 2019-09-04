<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Http\Traits\StoresUploads;

class InvoiceUploadController extends Controller
{


    /**
     * StoresUploads
     */
    use StoresUploads {
        upload as protected traitUpload;
    }


    /**
     * Returns a listing of the resource
     * 
     * @param Int $id
     * @return \Illuminate\Http\Response
     */
    public function index($id){
        $invoice = Invoice::findOrFail($id);
        $uploads = $invoice->uploads()->get();
        return response()->json(['uploads' => $uploads]);
    }


    /**
     * Uploads the file and updates db record
     *
     * @param Request $request
     * @param Int $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id){
        $invoice = Invoice::findOrFail($id);
        // TODO check on is editable 

        return $this->traitUpload($request, $invoice);
    }
}
