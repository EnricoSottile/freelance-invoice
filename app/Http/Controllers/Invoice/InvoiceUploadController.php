<?php

namespace App\Http\Controllers\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Helpers\InvoiceStatus;
use App\Http\Traits\StoresUploads;
use \Auth;

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
        $invoice = Auth::user()->invoices()->findOrFail($id);
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
        $invoice = Auth::user()->invoices()->findOrFail($id);
        $status = new InvoiceStatus($invoice);

        if ( ! $status->canBeUpdated() ) {
            abort(403, 'Invoice uploads cannot be edited');
        }

        return $this->traitUpload($request, $invoice);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $invoiceId
     * @param  int  $uploadId
     * @return \Illuminate\Http\Response
     */
    public function destroy($invoiceId, $uploadId)
    {
        $invoice = Invoice::findOrFail($invoiceId);  
        $status = new InvoiceStatus($invoice);

        if ( ! $status->canBeDeleted() ) {
            abort(403, 'Invoice uploads cannot be deleted');
        }

        $upload = $invoice->uploads()->where('id', $uploadId)->first();
        $upload->delete();

        return response()->json();
    }
}
