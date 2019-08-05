<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;

class TrashTest extends TestCase
{

    use RefreshDatabase;

    /**
     * [] of Model entities to test
     */
    private $resources;

    public function setUp() : void{
        parent::setUp();

        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create();
        $invoice = factory( Invoice::class )->create([
            'customer_id' => $customer->id, 
            'user_id' => $user->id, 
        ]);

        $this->resources = [
            factory( Customer::class )->create(),
            factory( Invoice::class )
                ->create([
                    'customer_id' => $customer->id, 
                    'user_id' => $user->id, 
                    'registered_date' => null ]),
            factory( Payment::class )
                ->create(['invoice_id' => $invoice->id, 'payed_date' => null])
        ];
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTrashableResourcesCanBeRestored()
    {
        foreach($this->resources as $res) {
            $resName = strtolower( class_basename(get_class($res)) );
            $resId = $res->id;
            $res->delete();
            $response = $this->get("/restore/${resName}/${resId}");
            $response->assertStatus(200);

            $dataCheck = array_merge($res->toArray(), ['deleted_at' => null]);
            $this->assertDatabaseHas($resName . "s", $dataCheck);
        }
    }

    

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTrashedResourcesCanBePermanentlyDeleted()
    {
        $this->withoutExceptionHandling();
        foreach($this->resources as $res) {
            $resName = strtolower( class_basename(get_class($res)) );
            $resId = $res->id;
            $res->delete();
            $response = $this->delete("/destroy/${resName}/${resId}");
            $response->assertStatus(200);
            $this->assertDatabaseMissing($resName . "s", $res->toArray());
        }
    }
}
