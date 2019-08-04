<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Invoice;
use Carbon\Carbon;

class InvoiceTest extends TestCase
{

    use RefreshDatabase;

    const CUSTOMER_ID = 1;
    const USER_ID = 1;


    /**
     * @return Invoice $invoice 
     */
    private function buildInvoice(){
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $invoice = new Invoice();
        $invoice->customer_id = self::CUSTOMER_ID;
        $invoice->user_id = self::USER_ID;
        $invoice->number = 'TEST_INVOICE';
        $invoice->net_amount = rand(0 * 100, 10000 * 100) / 100;
        $invoice->tax = rand(0 * 100, 100 * 100) / 100;
        $invoice->description = 'This is a test...';
        return $invoice;
    }


    /**
     * @return void
     */
    public function testInvoiceCanBeCreated()
    {
        $invoice = $this->buildInvoice();
        $this->assertTrue( $invoice->save() );
    }

    /**
     * @return void
     */
    public function testInvoiceCanBeUpdated()
    {
        $invoice = $this->buildInvoice();
        $invoice->save();
        
        $value_before = $invoice->date;
        $invoice->date = Carbon::now();

        $this->assertTrue( $invoice->save() );
        $this->assertTrue( $value_before !== $invoice->date );
    }



    /**
     * @return void
     */
    public function testInvoiceCanBeDeleted()
    {
        $invoice = $this->buildInvoice();
        $invoice->save();
        
        $this->assertTrue( $invoice->delete() );
    }


        /**
     * @return void
     */
    public function testInvoiceCanBePermanentlyDeleted()
    {
        $invoice = $this->buildInvoice();
        $invoice->save();
        $this->assertTrue( $invoice->forceDelete() );
    }

    /**
     * @return void
     */
    public function testInvoiceCannotBeUpdatedAfterRegistration(){
        $invoice = $this->buildInvoice();
        $invoice->registered_date = Carbon::now();
        $invoice->save();

        $invoice->date = Carbon::now();
        $this->expectException(\Exception::class);
        $invoice->save();
    }


    /**
     * @return void
     */
    public function testInvoiceCannotBeDeletedAfterRegistration(){
        $invoice = $this->buildInvoice();
        $invoice->registered_date = Carbon::now();
        $invoice->save();

        $this->expectException(\Exception::class);
        $invoice->delete();
    }


}
