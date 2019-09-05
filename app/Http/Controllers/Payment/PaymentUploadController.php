<?php

namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;
use App\Helpers\PaymentStatus;
use App\Http\Traits\StoresUploads;

class PaymentUploadController extends Controller
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
        $payment = Payment::findOrFail($id);
        $uploads = $payment->uploads()->get();
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
        $payment = Payment::findOrFail($id);
        $status = new PaymentStatus($payment);

        if ( ! $status->canBeUpdated() ) {
            abort(403, 'Payment uploads cannot be edited');
        }

        return $this->traitUpload($request, $payment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $paymentId
     * @param  int  $uploadId
     * @return \Illuminate\Http\Response
     */
    public function destroy($paymentId, $uploadId)
    {
        $payment = Payment::findOrFail($paymentId);  
        $status = new PaymentStatus($payment);

        if ( ! $status->canBeDeleted() ) {
            abort(403, 'Payment uploads cannot be deleted');
        }

        $upload = $payment->uploads()->where('id', $uploadId)->first();
        $upload->delete();

        return response()->json();
    }
}
