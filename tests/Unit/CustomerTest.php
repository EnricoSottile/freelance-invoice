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
     * @return void
     */
    public function testCustomerCanBeCreated()
    {
        $customer = factory( Customer::class )->make();
        $this->assertTrue( $customer->save() );
    }

    /**
     * @return void
     */
    public function testCustomerCanBeUpdated()
    {
        $customer = factory( Customer::class )->create();
        
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
        $customer = factory( Customer::class )->create();
        $this->assertTrue( $customer->delete() );
    }


        /**
     * @return void
     */
    public function testCustomerCanBePermanentlyDeleted()
    {
        $customer = factory( Customer::class )->create();        
        $this->assertTrue( $customer->forceDelete() );
    }
}
