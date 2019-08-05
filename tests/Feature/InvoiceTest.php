<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use \Carbon\Carbon;

use App\User;
use App\Models\Customer;
use App\Models\Invoice;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInvoiceIndex()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $count = rand(1, 10);
        factory( Invoice::class, $count )
            ->create(['customer_id' => 1, 'user_id' => 1]);

        $response = $this->get('/invoice');
        $response->assertStatus(200);
        $response->assertJsonCount($count);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInvoiceStore()
    {
        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create();

        $invoice = factory( Invoice::class )
                    ->make(['customer_id' => $customer->id]);
        $response = $this->actingAs($user)
                    ->post('/invoice', $invoice->toArray());
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('invoices', $invoice->toArray());
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInvoiceUpdateBeforeRegistration()
    {
        $data = ['net_amount' => rand(100, 10000)];
        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create();
        
        $invoice = factory( Invoice::class )
                    ->create([
                        'customer_id' => $customer->id, 
                        'user_id' => $user->id, 
                        'registered_date' => null]);
        
        $response = $this->actingAs($user)
                    ->put("/invoice/" . $invoice->id, $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('invoices', array_merge($invoice->toArray(), $data));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInvoiceUpdateAfterRegistration() 
    {
        $data = ['net_amount' => rand(100, 10000)];
        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create();

        $invoice = factory( Invoice::class )
        ->create([
            'customer_id' => $customer->id, 
            'user_id' => $user->id, 
            'registered_date' => Carbon::now() ]);

        $response = $this->actingAs($user)
                ->put("/invoice/" . $invoice->id, $data);
        $response->assertStatus(500);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInvoiceDestroyBeforeRegistration()
    {
        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create();
        
        $invoice = factory( Invoice::class )
                    ->create([
                        'customer_id' => $customer->id, 
                        'user_id' => $user->id, 
                        'registered_date' => null]);


        $id = $invoice->id;
        $response = $this->delete("/invoice/${id}");
        $response->assertStatus(200);

        $this->assertSoftDeleted('invoices', [
            'id' => $id,
        ]);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInvoiceDestroyAfterRegistration()
    {
        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create();
        
        $invoice = factory( Invoice::class )
                    ->create([
                        'customer_id' => $customer->id, 
                        'user_id' => $user->id, 
                        'registered_date' => Carbon::now()]);

        $id = $invoice->id;
        $response = $this->delete("/invoice/${id}");
        $response->assertStatus(500);
    }


}