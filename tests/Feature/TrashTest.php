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
     * Array[] of Model entities to test
     */
    private $resources;

    public function setUp() : void{
        parent::setUp();

        $user = factory(User::class)->create();
        $customer = factory( Customer::class )->create(['user_id' => $user->id]);
        $invoice = factory( Invoice::class )->create([
            'customer_id' => $customer->id, 
            'user_id' => $user->id, 
        ]);

        $this->resources = [
            factory( Customer::class )->create(['user_id' => $user->id]),
            factory( Invoice::class )
                ->create([
                    'customer_id' => $customer->id, 
                    'user_id' => $user->id, 
                    'registered_date' => null ]),
            factory( Payment::class )
                ->create(['invoice_id' => $invoice->id, 'user_id' => $user->id, 'payed_date' => null])
        ];
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTrashableResourcesCanBeRestored()
    {
        $user = factory(User::class)->create();

        foreach($this->resources as $res) {
            $resName = strtolower( class_basename(get_class($res)) );
            $resId = $res->id;
            $res->delete();
            $route = route('trash.restore', ['resource' => $resName, 'id' => $resId]);
            $response = $this->actingAs($user)->get($route);
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
        $user = factory(User::class)->create();

        foreach($this->resources as $res) {
            $resName = strtolower( class_basename(get_class($res)) );
            $resId = $res->id;
            $res->delete();
            $route = route('trash.destroy', ['resource' => $resName, 'id' => $resId]);
            $response = $this->actingAs($user)->delete($route);
            $response->assertStatus(200);
            $this->assertDatabaseMissing($resName . "s", $res->toArray());
        }
    }
}
