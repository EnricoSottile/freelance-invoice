<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Invoice;
use Carbon\Carbon;

class InvoiceTest extends TestCase
{

    const INVOICE_NUMBER = 'TEST_INVOICE';
    const CUSTOMER_ID = 1;
    const USER_ID = 1;


    /**
     * @return void
     */
    public function testInvoiceCanBeCreated()
    {

        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        $invoice = new Invoice();
        $invoice->customer_id = self::CUSTOMER_ID;
        $invoice->user_id = self::USER_ID;
        $invoice->number = self::INVOICE_NUMBER;
        $invoice->net_amount = rand(0 * 100, 10000 * 100) / 100;
        $invoice->tax = rand(0 * 100, 100 * 100) / 100;
        $invoice->description = 'This is a test...';

        $this->assertTrue( $invoice->save() );
    }

    /**
     * @return void
     */
    public function testInvoiceCanBeUpdated()
    {
        $invoice = Invoice::where('number', self::INVOICE_NUMBER)
                    ->orderBy('created_at', 'desc')->first();
        
        $value_before = $invoice->date;
        $invoice->date = Carbon::now();
        
        $this->assertTrue( $invoice->save() );
        
        $invoice = Invoice::where('number', self::INVOICE_NUMBER)
                    ->orderBy('created_at', 'desc')->first();
        $this->assertTrue( $value_before !== $invoice->date );
    }



    /**
     * @return void
     */
    public function testInvoiceCanBeDeleted()
    {
        $invoice = Invoice::where('number', self::INVOICE_NUMBER)
                    ->orderBy('created_at', 'desc')->first();
        
        $this->assertTrue( $invoice->delete() );
    }


        /**
     * @return void
     */
    public function testInvoiceCanBePermanentlyDeleted()
    {
        $invoice = Invoice::withTrashed()->where('number', self::INVOICE_NUMBER)
                    ->orderBy('created_at', 'desc')->first();
        
        $this->assertTrue( $invoice->forceDelete() );
    }


}
