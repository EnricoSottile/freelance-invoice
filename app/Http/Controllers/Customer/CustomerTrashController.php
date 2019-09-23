<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \Auth;
use App\Models\Customer;
use App\Http\Traits\DestroyAndRestore;


class CustomerTrashController extends Controller
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
        $customer = Auth::user()->customers()->onlyTrashed()->findOrFail($id);
        return $this->traitRestore($customer);
    }


    /**
     * Completely deletes the file from trash
     *
     * @param Int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $customer = Auth::user()->customers()->onlyTrashed()->findOrFail($id);
        return $this->traitDestroy($customer);
    }



}
