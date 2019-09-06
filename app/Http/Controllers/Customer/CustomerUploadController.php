<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Helpers\CustomerStatus;
use App\Http\Traits\StoresUploads;
use \Auth;

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
        $customer = Auth::user()->customers()->findOrFail($id);
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
        $customer = Auth::user()->customers()->findOrFail($id);

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
        $customer = Auth::user()->customers()->findOrFail($customerId);  
        $status = new CustomerStatus($customer);

        if ( ! $status->canBeDeleted() ) {
            abort(403, 'Customer uploads cannot be deleted');
        }

        $upload = $customer->uploads()->where('id', $uploadId)->first();
        $upload->delete();

        return response()->json();
    }
}
