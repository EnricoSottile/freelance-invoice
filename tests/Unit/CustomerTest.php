<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Customer;

class CustomerTest extends TestCase
{
    
    const CUSTOMER_NAME = 'TEST_CUSTOMER';

    /**
     * @return void
     */
    public function testCustomerCanBeCreated()
    {
        $customer = new Customer();
        $customer->full_name = self::CUSTOMER_NAME;
        $customer->email = 'test.customer@app.test';
        $customer->phone = '+0123456789';
        $customer->vat_code = 'IT0123456789';

        $this->assertTrue( $customer->save() );
    }

    /**
     * @return void
     */
    public function testCustomerCanBeUpdated()
    {
        $customer = Customer::where('full_name', self::CUSTOMER_NAME)
                    ->orderBy('created_at', 'desc')->first();
        
        $value_before = $customer->email;
        $customer->email = 'test.new.mail@app.test';
        
        $this->assertTrue( $customer->save() );
        
        $customer = Customer::where('full_name', self::CUSTOMER_NAME)
                    ->orderBy('created_at', 'desc')->first();
        $this->assertTrue( $value_before !== $customer->date );
    }



    /**
     * @return void
     */
    public function testCustomerCanBeDeleted()
    {
        $customer = Customer::where('full_name', self::CUSTOMER_NAME)
                    ->orderBy('created_at', 'desc')->first();
        
        $this->assertTrue( $customer->delete() );
    }


        /**
     * @return void
     */
    public function testCustomerCanBePermanentlyDeleted()
    {
        $customer = Customer::withTrashed()->where('full_name', self::CUSTOMER_NAME)
                    ->orderBy('created_at', 'desc')->first();
        
        $this->assertTrue( $customer->forceDelete() );
    }
}
