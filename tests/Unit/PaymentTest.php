<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Payment;
use Carbon\Carbon;

class PaymentTest extends TestCase
{

    use RefreshDatabase;


    /**
     * @return Payment $payment
     */
    private function buildPayment() : Payment {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $payment = new Payment();
        $payment->invoice_id = 1;
        return $payment;
    }

    /**
     *
     * @return void
     */
    public function testPaymentCanBeCreated()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $payment = $this->buildPayment();
        $this->assertTrue( $payment->save() );
    }

        /**
     *
     * @return void
     */
    public function testPaymentCanBeUpdated()
    {
        $payment = $this->buildPayment();
        $payment->save();

        $value_before = $payment->net_amount;
        $payment->net_amount = 100.50;

        $this->assertTrue( $payment->save() );
        $payment->fresh();
        $this->assertTrue( $value_before !== $payment->net_amount );
    }

    /**
     *
     * @return void
     */
    public function testPaymentCanBeDeleted()
    {
        $payment = $this->buildPayment();
        $payment->save();

        $this->assertTrue( $payment->delete() );
    }


    /**
     *
     * @return void
     */
    public function testPaymentCanBePermanentlyDeleted()
    {
        $payment = $this->buildPayment();
        $payment->save();

        $this->assertTrue( $payment->forceDelete() );
    }


    /**
     * @return void
     */
    public function testPaymentCannotBeUpdatedIfPayed(){
        $payment = $this->buildPayment();
        $payment->payed_date = Carbon::now();
        $payment->save();

        $payment->net_amount = rand(0,1000);
        $this->expectException(\Exception::class);
        $payment->save();
    }


    /**
     * @return void
     */
    public function testPaymentCannotBeDeletedIfPayed(){
        $payment = $this->buildPayment();
        $payment->payed_date = Carbon::now();
        $payment->save();

        $this->expectException(\Exception::class);
        $payment->delete();
    }
}
