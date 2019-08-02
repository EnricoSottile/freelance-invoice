<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Invoice;
use App\Models\Payment;

class PaymentTest extends TestCase
{

    const INVOICE_NUMBER = 'TEST_INVOICE_WITH_PAYMENTS';


    /**
     *
     * @return void
     */
    public function testPaymentCanBeCreated()
    {
        $invoice = new Invoice();
        $invoice->number = self::INVOICE_NUMBER;
        $invoice->save();

        $payment = new Payment();
        $payment->invoice_id = $invoice->id;
        $this->assertTrue( $payment->save() );
    }

        /**
     *
     * @return void
     */
    public function testPaymentCanBeUpdated()
    {
        $invoice = Invoice::where('number', self::INVOICE_NUMBER)->orderBy('created_at', 'desc')->first();
        $payment = Payment::where('invoice_id', $invoice->id)->first();
        $value_before = $payment->net_amount;

        $payment->net_amount = 100.50;
        $this->assertTrue( $payment->save() );

        $payment = Payment::where('invoice_id', $invoice->id)->first();
        $this->assertTrue( $value_before !== $payment->net_amount );
    }

    /**
     *
     * @return void
     */
    public function testPaymentCanBeDeleted()
    {
        $invoice = Invoice::where('number', self::INVOICE_NUMBER)->orderBy('created_at', 'desc')->first();
        $payment = Payment::where('invoice_id', $invoice->id)->first();

        $this->assertTrue( $payment->delete() );
    }


    /**
     *
     * @return void
     */
    public function testPaymentCanBePermanentlyDeleted()
    {
        $invoice = Invoice::where('number', self::INVOICE_NUMBER)->orderBy('created_at', 'desc')->first();
        $payment = Payment::withTrashed()->where('invoice_id', $invoice->id)->first();

        $this->assertTrue( $payment->forceDelete() );
        $this->assertTrue( $invoice->forceDelete() );
    }
}
