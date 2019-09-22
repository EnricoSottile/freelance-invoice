<?php

namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;

use App\Http\Requests\StorePayment;
use App\Http\Requests\UpdatePayment;
use App\Services\PaymentService;
use \Auth;

class PaymentController extends Controller
{

    // used everywhere but index 
    // (because it's heavy on performance and not needed)
    protected $appends = ['is_editable', 'is_destroyable'];


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()
            ->payments()
            ->with('invoice:id,number')
            ->get()
            ->toJson();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePayment $request, PaymentService $paymentService)
    {        
        $payment = $paymentService->store( $request->getDto() );
        $payment->setAppends($this->appends);
        return response()->json(['payment' => $payment]);
    }

    /**
     * Show the resource
     *
     * @param  int  $id
     * @return Payment
     */
    public function show($id)
    {
        $payment = Auth::user()->payments()->findOrFail($id);
        return $payment->setAppends($this->appends)->toJson();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePayment $request, PaymentService $paymentService, $id)
    {

        $payment = $paymentService->update( $request->getDto(), $id );
        $payment->setAppends($this->appends);
        return response()->json(['payment' => $payment]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Auth::user()->payments()->findOrFail($id);  
        $payment->delete();
        return response()->json();
    }

}
