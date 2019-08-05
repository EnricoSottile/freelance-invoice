<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Customer;

class CustomerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCustomerIndex()
    {
        $count = rand(1, 10);
        factory( Customer::class, $count )->create();

        $response = $this->get('/customer');
        $response->assertStatus(200);
        $response->assertJsonCount($count);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCustomerStore()
    {
        $customer = factory( Customer::class )->make();
        $response = $this->post('/customer', $customer->toArray());
        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', $customer->toArray());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCustomerUpdate()
    {
        $data = ['email' => 'test' . rand(10, 100) . '@mail.com'];

        $customer = factory( Customer::class )->create();
        $update = array_merge($customer->toArray(), $data);
        $response = $this->put("/customer/" . $customer->id, $update);

        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', $update);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCustomerDestroy()
    {
        $customer = factory( Customer::class )->create();
        $id = $customer->id;
        
        $response = $this->delete("/customer/${id}");
        $response->assertStatus(200);

        $this->assertSoftDeleted('customers', [
            'id' => $id,
        ]);
    }
}
