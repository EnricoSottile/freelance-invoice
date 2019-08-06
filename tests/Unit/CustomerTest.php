<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Customer;

class CustomerTest extends TestCase
{

    use RefreshDatabase;

     /**
     * @return Customer $customer 
     */
    private function buildCustomer() : Customer {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $customer = factory( Customer::class )
                    ->make(['user_id' => 1]);

        return $customer;
    }
    
    /**
     * @return void
     */
    public function testCustomerCanBeCreated()
    {
        $customer = $this->buildCustomer();
        $this->assertTrue( $customer->save() );
    }

    /**
     * @return void
     */
    public function testCustomerCanBeUpdated()
    {
        $customer = $this->buildCustomer();
        
        $value_before = $customer->email;
        $customer->email = 'test.new.mail@app.test';
        
        $this->assertTrue( $customer->save() );
        $customer->fresh();
        $this->assertTrue( $value_before !== $customer->email );
    }



    /**
     * @return void
     */
    public function testCustomerCanBeDeleted()
    {
        $customer = $this->buildCustomer();
        $customer->save();
        $this->assertTrue( $customer->delete() );
    }


        /**
     * @return void
     */
    public function testCustomerCanBePermanentlyDeleted()
    {
        $customer = $this->buildCustomer();      
        $customer->save();
        $this->assertTrue( $customer->forceDelete() );
    }
}
