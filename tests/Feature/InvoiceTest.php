<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use \Carbon\Carbon;

use App\User;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;

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
        $user = factory(User::class)->create();
        $count = rand(1, 10);
        factory( Invoice::class, $count )
            ->create(['customer_id' => 1, 'user_id' => 1]);

        $response = $this->actingAs($user)->get(route('invoice.index'));
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
        $customer = factory( Customer::class )->create(['user_id' => $user->id]);

        $invoice = factory( Invoice::class )
                    ->make(['customer_id' => $customer->id]);

        $response = $this->actingAs($user)
                    ->post(route('invoice.store'), $invoice->toArray());
        
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
        $customer = factory( Customer::class )->create(['user_id' => $user->id]);
        
        $invoice = factory( Invoice::class )
                    ->create([
                        'customer_id' => $customer->id, 
                        'user_id' => $user->id, 
                        'registered_date' => null]);
        
        $update = array_merge($invoice->toArray(), $data);
        $response = $this->actingAs($user)
                    ->put(route('invoice.update', $invoice->id), $update);

        $response->assertStatus(200);
        $this->assertDatabaseHas('invoices', $update);
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
        $customer = factory( Customer::class )->create(['user_id' => $user->id]);

        $invoice = factory( Invoice::class )
        ->create([
            'customer_id' => $customer->id, 
            'user_id' => $user->id, 
            'registered_date' => Carbon::now() ]);

        $update = array_merge($invoice->toArray(), $data);
        $response = $this->actingAs($user)
                ->put(route('invoice.update', $invoice->id), $update);
        
        $response->assertStatus(403);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInvoiceDestroyBeforeRegistration()
    {
        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create(['user_id' => $user->id]);
        
        $invoice = factory( Invoice::class )
                    ->create([
                        'customer_id' => $customer->id, 
                        'user_id' => $user->id, 
                        'registered_date' => null]);


        $id = $invoice->id;
        $response = $this->actingAs($user)->delete(route('invoice.destroy', $id));
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
        $customer = factory( Customer::class )->create(['user_id' => $user->id]);
        
        $invoice = factory( Invoice::class )
                    ->create([
                        'customer_id' => $customer->id, 
                        'user_id' => $user->id, 
                        'registered_date' => Carbon::now()]);

        $id = $invoice->id;
        $response = $this->actingAs($user)->delete(route('invoice.destroy', $id));
        $response->assertStatus(403);
    }




    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInvoiceCannotBeDestroyedIfHasBeenPayed()
    {
        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create(['user_id' => $user->id]);
        $invoice = factory( Invoice::class)
                    ->create([
                        'customer_id' => $customer->id, 
                        'user_id' => $user->id, 
                        'registered_date' => null]);
        
        $payments = factory( Payment::class, 3)
                    ->create([
                        'user_id' => $user->id,
                        'invoice_id' => $invoice->id, 
                        'payed_date' => Carbon::now()]);
        
        $id = $invoice->id;
        $response = $this->actingAs($user)->delete(route('invoice.destroy', $id));
        $response->assertStatus(403);
        $this->assertDatabaseHas('invoices', ['id' => $id, 'deleted_at' => null]);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInvoiceCanBeDestroyedIfHasUnpayedPayments()
    {
        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create(['user_id' => $user->id]);
        $invoice = factory( Invoice::class)
                    ->create([
                        'customer_id' => $customer->id, 
                        'user_id' => $user->id, 
                        'registered_date' => null]);
        
        $payments = factory( Payment::class, 3)
                    ->create([
                        'user_id' => $user->id,
                        'invoice_id' => $invoice->id, 
                        'payed_date' => null]);
        
        $id = $invoice->id;
        $response = $this->actingAs($user)->delete(route('invoice.destroy', $id));
        $response->assertStatus(200);
        $this->assertSoftDeleted('invoices', ['id' => $id]);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeletingInvoiceDeletesOwnUnpayedPayments()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $user = factory(User::class)->create();

        $invoice = factory( Invoice::class )
                    ->create(['customer_id' => 1, 'user_id' => $user->id, 'registered_date' => null]);
        $payments = factory( Payment::class, 3)
        ->create([
            'user_id' => $user->id,
            'invoice_id' => $invoice->id, 
            'payed_date' => null]);

        $invoice->delete();
        foreach($payments as $p) {
            $this->assertSoftDeleted('payments', $p->toArray());
        }
    }


        /**
     * A basic test example.
     *
     * @return void
     */
    public function testRestoringInvoiceRestoresOwnUnpayedPayments()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $user = factory(User::class)->create();
        $invoice = factory( Invoice::class )
                    ->create(['customer_id' => 1, 'user_id' => $user->id, 'registered_date' => null]);
        $payments = factory( Payment::class, 3)
        ->create([
            'user_id' => $user->id,
            'invoice_id' => $invoice->id, 
            'payed_date' => null]);

        $invoice->delete();
        $invoice->restore();
        foreach($payments as $p) {
            $this->assertDatabaseHas('payments', ['id' => $p->id, 'deleted_at' => null]);
        }
    }


}
