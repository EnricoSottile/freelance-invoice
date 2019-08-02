<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Invoice;

class InvoiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testInvoiceCanBeCreated()
    {
        $invoice = new Invoice();
        $invoice->save();
    }
}
