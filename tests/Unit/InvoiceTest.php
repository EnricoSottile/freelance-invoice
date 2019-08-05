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
    private function buildInvoice() : Invoice {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $invoice = factory( Invoice::class )
                    ->make(['customer_id' => 1, 'user_id' => 1]);

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
        $invoice->registered_date = null;
        $invoice->save();
        
        $value_before = $invoice->date;
        $invoice->date = Carbon::now();

        $this->assertTrue( $invoice->save() );
        $invoice->fresh();
        $this->assertTrue( $value_before !== $invoice->date );
    }



    /**
     * @return void
     */
    public function testInvoiceCanBeDeleted()
    {
        $invoice = $this->buildInvoice();
        $invoice->registered_date = null;
        $invoice->save();
        
        $this->assertTrue( $invoice->delete() );
    }


        /**
     * @return void
     */
    public function testInvoiceCanBePermanentlyDeleted()
    {
        $invoice = $this->buildInvoice();
        $invoice->registered_date = null;
        $invoice->save();
        $this->assertTrue( $invoice->forceDelete() );
    }

    /**
     * @return void
     */
    public function testInvoiceIsRegisteredMethod(){
        $invoice = $this->buildInvoice();
        $invoice->registered_date = null;
        $this->assertTrue( $invoice->isRegistered() === false);

        $invoice->registered_date = Carbon::now();
        $this->assertTrue( $invoice->isRegistered() === true);
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
