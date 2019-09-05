<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;
// use App\Helpers\InvoiceStatus;
use App\Http\Traits\StoresUploads;

class CustomerUploadController extends Controller
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
        $customer = Customer::findOrFail($id);
        $uploads = $customer->uploads()->get();
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
        $customer = Customer::findOrFail($id);
        // $status = new CustomerStatus($customer);

        // if ( ! $status->canBeUpdated() ) {
        //     abort(403, 'Customer uploads cannot be edited');
        // }

        return $this->traitUpload($request, $customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $customerId
     * @param  int  $uploadId
     * @return \Illuminate\Http\Response
     */
    public function destroy($customerId, $uploadId)
    {
        $customer = Customer::findOrFail($customerId);  
        // $status = new CustomerStatus($customer);

        // if ( ! $status->canBeDeleted() ) {
        //     abort(403, 'Customer uploads cannot be deleted');
        // }

        $upload = $customer->uploads()->where('id', $uploadId)->first();
        $upload->delete();

        return response()->json();
    }
}
