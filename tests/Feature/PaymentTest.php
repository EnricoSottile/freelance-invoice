<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use \Carbon\Carbon;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPaymentIndex()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $count = rand(1, 10);
        factory( Payment::class, $count )
            ->create(['invoice_id' => 1, ]);

        $response = $this->get('/payment');
        $response->assertStatus(200);
        $response->assertJsonCount($count);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPaymentStore()
    {
        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create();
        $invoice = factory( Invoice::class )
                    ->create(['customer_id' => $customer->id, 'user_id' => $user->id]);

        $payment = factory( Payment::class )
            ->make(['invoice_id' => $invoice->id]);   
        $response = $this->actingAs($user)
                    ->post('/payment', $payment->toArray());
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', $payment->toArray());
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPaymentUpdateBeforeRegistration()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $user = factory(User::class)->create();
        $data = ['net_amount' => rand(100, 10000)];
    
        $payment = factory( Payment::class )
                    ->create([
                        'invoice_id' => 1, 
                        'payed_date' => null]);
        
        $update = array_merge($payment->toArray(), $data);
        $response = $this->actingAs($user)
                    ->put("/payment/" . $payment->id, $update);

        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', $update);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPaymentUpdateAfterRegistration() 
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $user = factory(User::class)->create();
        $data = ['net_amount' => rand(100, 10000)];
    
        $payment = factory( Payment::class )
                    ->create([
                        'invoice_id' => 1, 
                        'payed_date' => Carbon::now()]);
        
        $update = array_merge($payment->toArray(), $data);
        $response = $this->actingAs($user)
                    ->put("/payment/" . $payment->id, $update);

        $response->assertStatus(500);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPaymentDestroyBeforeRegistration()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $payment = factory( Payment::class )
                    ->create([
                        'invoice_id' => 1, 
                        'payed_date' => null]);

        $id = $payment->id;
        $response = $this->delete("/payment/${id}");
        $response->assertStatus(200);

        $this->assertSoftDeleted('payments', [
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
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $payment = factory( Payment::class )
                    ->create([
                        'invoice_id' => 1, 
                        'payed_date' => Carbon::now()]);

        $id = $payment->id;
        $response = $this->delete("/payment/${id}");
        $response->assertStatus(500);
    }

}
