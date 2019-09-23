<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Auth;

class TrashController extends Controller
{


    /**
     * Returns all trashed items 
     *
     * @param  String  $resource
     * @return Model
     */
    public function index(){
        $user = Auth::user();

        return response()->json([
            'customers' => $user->customers()->onlyTrashed()->get(),
            'invoices' => $user->invoices()->onlyTrashed()->get(),
            'payments' => $user->payments()->onlyTrashed()->get(),
        ]);
    }


    /**
     * Show the resource
     *
     * @param  String  $resource
     * @param  int  $id
     * @return Invoice|Customer|Payment
     */
    public function show($resource, $id)
    {
        $trashed = $this->getRelation($resource)->findOrFail($id);
        return $trashed->toJson();
    }

}
