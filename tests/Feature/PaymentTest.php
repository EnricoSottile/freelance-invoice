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

    private function getCommonModels() {
        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create(['user_id' => $user->id]);
        $invoice = factory( Invoice::class )
                    ->create(['customer_id' => $customer->id, 'user_id' => $user->id]);

        return (Object)[
            'user' => $user,
            'customer' => $customer,
            'invoice' => $invoice,
        ];
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPaymentIndex()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $models = $this->getCommonModels();
        $user = $models->user;
        $count = rand(1, 10);
        factory( Payment::class, $count )
            ->create(['invoice_id' => 1, 'user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('payment.index'));
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
        $models = $this->getCommonModels();
        $user = $models->user;
        $invoice = $models->invoice;

        $payment = factory( Payment::class )
            ->make(['invoice_id' => $invoice->id]);
            
        $response = $this->actingAs($user)
                    ->post(route('payment.store'), $payment->toArray());
        
                    
        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', $payment->toArray());
        $response->assertJsonStructure(['payment']);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPaymentUpdateBeforeRegistration()
    {
        $models = $this->getCommonModels();
        $user = $models->user;
        $invoice = $models->invoice;
        $data = ['net_amount' => rand(100, 10000)];
    
        $payment = factory( Payment::class )
                    ->create([
                        'user_id' => $user->id,
                        'invoice_id' => $invoice->id, 
                        'payed_date' => null]);
        
        $update = array_merge($payment->toArray(), $data);
        $response = $this->actingAs($user)
                    ->put(route('payment.update', $payment->id), $update);

        $response->assertStatus(200);
        $this->assertDatabaseHas('payments', $update);
        $response->assertJsonStructure(['payment']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPaymentUpdateAfterRegistration() 
    {
        $models = $this->getCommonModels();
        $user = $models->user;
        $invoice = $models->invoice;
        $data = ['net_amount' => rand(100, 10000)];
    
        $payment = factory( Payment::class )
                    ->create([
                        'user_id' => $user->id,
                        'invoice_id' => $invoice->id, 
                        'payed_date' => Carbon::now()]);
        
        $update = array_merge($payment->toArray(), $data);
        $response = $this->actingAs($user)
                    ->put(route('payment.update', $payment->id), $update);

                    $response->assertStatus(403);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPaymentDestroyBeforeRegistration()
    {
        $models = $this->getCommonModels();
        $user = $models->user;
        $invoice = $models->invoice;
        $payment = factory( Payment::class )
                    ->create([
                        'user_id' => $user->id,
                        'invoice_id' => $invoice->id, 
                        'payed_date' => null]);

        $id = $payment->id;
        $response = $this->actingAs($user)->delete(route('payment.destroy', $id));
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
        $models = $this->getCommonModels();
        $user = $models->user;
        $invoice = $models->invoice;
        $payment = factory( Payment::class )
                    ->create([
                        'user_id' => $user->id,
                        'invoice_id' => $invoice->id, 
                        'payed_date' => Carbon::now()]);

        $id = $payment->id;
        $response = $this->actingAs($user)->delete(route('payment.destroy', $id));
        $response->assertStatus(403);
    }



    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRestoringPaymentRestoresOwnParent()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create(['user_id' => $user->id]);
        $invoice = factory( Invoice::class )
                    ->create(['customer_id' => $customer->id, 'user_id' => $user->id, 'registered_date' => null]);
        $payments = factory( Payment::class)
            ->create([
                'user_id' => $user->id,
                'invoice_id' => $invoice->id, 
                'payed_date' => null]);

        $payments->delete();
        $invoice->delete();
        $payments->restore();

        $this->assertDatabaseHas('invoices', ['id' => $invoice->id, 'deleted_at' => null]);
    }

}
