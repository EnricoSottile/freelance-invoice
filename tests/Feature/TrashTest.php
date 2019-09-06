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

    protected $user;

    /**
     * Array[] of Model entities to test
     */
    private $resources;

    public function setUp() : void{
        parent::setUp();

        $this->user = factory(User::class)->create();
        $userId = $this->user->id;

        $customer = factory( Customer::class )->create(['user_id' => $userId]);
        $invoice = factory( Invoice::class )->create([
            'customer_id' => $customer->id, 
            'user_id' => $userId, 
            'registered_date' => null
        ]);

        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $this->resources = [
            $customer,
            $invoice,
            factory( Payment::class )
                ->create(['invoice_id' => $invoice->id, 'user_id' => $userId, 'payed_date' => null])
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
            $route = route('trash.restore', ['resource' => $resName, 'id' => $resId]);
            $response = $this->actingAs($this->user)->get($route);
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
            $route = route('trash.destroy', ['resource' => $resName, 'id' => $resId]);
            $response = $this->actingAs($this->user)->delete($route);
            $response->assertStatus(200);
            $this->assertDatabaseMissing($resName . "s", $res->toArray());
        }
    }
}
