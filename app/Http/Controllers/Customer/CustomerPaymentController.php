<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use \Auth;


class CustomerPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Int $id)
    {
        $customer = Auth::user()->customers()->findOrFail($id);
        return $customer->payments()->get()->toJson();
    }
}
