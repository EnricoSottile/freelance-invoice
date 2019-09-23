<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \Auth;
use App\Models\Payment;
use App\Http\Traits\DestroyAndRestore;


class PaymentTrashController extends Controller
{
    
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
        $payment = Auth::user()->payments()->onlyTrashed()->findOrFail($id);
        return $this->traitRestore($payment);
    }


    /**
     * Completely deletes the file from trash
     *
     * @param Int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $payment = Auth::user()->payments()->onlyTrashed()->findOrFail($id);
        return $this->traitDestroy($payment);
    }



}
