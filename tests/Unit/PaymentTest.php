<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Payment;

class PaymentTest extends TestCase
{

    const INVOICE_ID = 1;

    /**
     *
     * @return void
     */
    public function testPaymentCanBeCreated()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $payment = new Payment();
        $payment->invoice_id = self::INVOICE_ID;
        $this->assertTrue( $payment->save() );
    }

        /**
     *
     * @return void
     */
    public function testPaymentCanBeUpdated()
    {
        $payment = Payment::where('invoice_id', self::INVOICE_ID)->first();
        $value_before = $payment->net_amount;

        $payment->net_amount = 100.50;
        $this->assertTrue( $payment->save() );

        $payment = Payment::where('invoice_id', self::INVOICE_ID)->first();
        $this->assertTrue( $value_before !== $payment->net_amount );
    }

    /**
     *
     * @return void
     */
    public function testPaymentCanBeDeleted()
    {
        $payment = Payment::where('invoice_id', self::INVOICE_ID)->first();
        $this->assertTrue( $payment->delete() );
    }


    /**
     *
     * @return void
     */
    public function testPaymentCanBePermanentlyDeleted()
    {
        $payment = Payment::withTrashed()->where('invoice_id', self::INVOICE_ID)->first();
        $this->assertTrue( $payment->forceDelete() );
    }
}
