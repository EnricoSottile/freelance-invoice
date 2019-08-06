<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use \Carbon\Carbon;

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


        /**
     * A basic test example.
     *
     * @return void
     */
    public function testCustomerDestroyAlsoDestroyesUnregisteredInvoicesAndPayments()
    {
        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create();
        $id = $customer->id;
        $invoice = factory( Invoice::class )
            ->create(['customer_id' => $id, 'user_id' => $user->id, 'registered_date' => null]);
        
        $payments = factory( Payment::class, 3)
            ->create([
                'invoice_id' => $invoice->id, 
                'payed_date' => null]);

        $customer->delete();

        $this->assertSoftDeleted('invoices', [
            'id' => $invoice->id,
        ]);
        foreach($payments as $p) {
            $this->assertSoftDeleted('payments', [
                'id' => $p->id,
            ]); 
        }
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCustomerCannotBeDestroyedIfHasRegisteredInvoices()
    {
        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create();
        $id = $customer->id;
        factory( Invoice::class )
            ->create(['customer_id' => $id, 'user_id' => $user->id, 'registered_date' => Carbon::now()]);

        
        
        $response = $this->delete("/customer/${id}");
        $response->assertStatus(500);
    }


    /**
     * A basic test example.
     * The problem here is that an invoice can be payed 
     * even if it has not been registered yet
     *
     * @return void
     */
    public function testCustomerCannotBeDestroyedIfHasRegisteredPayments()
    {
        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create();
        $id = $customer->id;
        $invoice = factory( Invoice::class )
            ->create(['customer_id' => $id, 'user_id' => $user->id, 'registered_date' => null]);

        factory( Payment::class, 3)
            ->create([
                'invoice_id' => $invoice->id, 
                'payed_date' => Carbon::now()]);
        
        
        $response = $this->delete("/customer/${id}");
        $response->assertStatus(500);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRestoringCustomerRestoresTrashedInvoicesAndPayments()
    {
        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create();
        $id = $customer->id;
        $invoice = factory( Invoice::class )
            ->create(['customer_id' => $id, 'user_id' => $user->id, 'registered_date' => null]);

        $payments = factory( Payment::class, 3)
            ->create([
                'invoice_id' => $invoice->id, 
                'payed_date' => null]);
        
        $customer->delete();
        $customer->restore();
        $this->assertDatabaseHas('invoices', ['id' => $invoice->id, 'deleted_at' => null]);
        foreach($payments as $p) {
            $this->assertDatabaseHas('payments', ['id' => $p->id, 'deleted_at' => null]);
        }
    }

}
