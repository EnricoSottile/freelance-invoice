<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Invoice;
use Carbon\Carbon;

class InvoiceTest extends TestCase
{

    /** 
     * used for testing purposes
     */
    const INVOICE_NUMBER = 'TEST_INVOICE';


    /**
     * @return void
     */
    public function testInvoiceCanBeCreated()
    {
        $invoice = new Invoice();
        $invoice->number = self::INVOICE_NUMBER;
        $invoice->net_amount = rand(0 * 100, 10000 * 100) / 100;
        $invoice->tax = rand(0 * 100, 100 * 100) / 100;
        $invoice->description = 'This is a test...';
        $invoice->date = null;
        $invoice->sent_date = null;
        $invoice->registered_date = null;

        $this->assertTrue( $invoice->save() );
    }

    /**
     * @return void
     */
    public function testInvoiceCanBeUpdated()
    {
        $invoice = Invoice::where('number', self::INVOICE_NUMBER)->first();
        
        $val_before = $invoice->date;
        $invoice->date = Carbon::now();
        
        $this->assertTrue( $invoice->save() );
        
        $invoice = Invoice::where('number', self::INVOICE_NUMBER)->first();
        $this->assertTrue( $val_before !== $invoice->date );
    }



    /**
     * @return void
     */
    public function testInvoiceCanBeDeleted()
    {
        $invoice = Invoice::where('number', self::INVOICE_NUMBER)->first();
        
        $this->assertTrue( $invoice->delete() );
        $this->assertTrue( $invoice->forceDelete() );
    }


}
