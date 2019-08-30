<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;

class CustomerInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Int $id)
    {
        $customer = Customer::findOrFail($id);
        return $customer->invoices()->get()->toJson();
    }

}
