<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadTest extends TestCase
{

    /**
     * 
     */
    private $user;


    /**
     * 
     */
    private $customer;


    /**
     * 
     */
    private $invoice;


    /**
     * 
     */
    private $payment;

    /**
     * set up the needed resources
     */
    public function setUp() : void{
        parent::setUp();

        $user = factory(User::class)->create();
        $this->user = $user;

        $customer = factory( Customer::class )->create(['user_id' => $user->id]);
        $invoice = factory( Invoice::class )->create([
            'customer_id' => $customer->id, 
            'user_id' => $user->id, 
            'registered_date' => null,
        ]);

        $payment = factory( Payment::class )->create([
            'invoice_id' => $invoice->id, 
            'user_id' => $user->id, 
            'payed_date' => null
        ]);

        $this->customer = $customer;
        $this->invoice = $invoice;
        $this->payment = $payment;
    }



    /**
     * Test files can be uploaded
     *
     * @return void
     */
    public function testResourceUploads(){
        $user = $this->user;
        $resources = ['customer', 'invoice', 'payment'];
        foreach($resources as $resource) {
            
            $resourceId = $this->{$resource}->id;
            $response = $this->actingAs($user)
                            ->json('POST', route("${resource}.upload.store", ["${resource}" => $resourceId]), [
                'upload' => UploadedFile::fake()->image('')
            ]);
    
            $file = $response->getOriginalContent()['upload'];
            $path = $file['path'];
            Storage::disk('')->assertExists( $path );
            $this->assertDatabaseHas('uploads', [
                'id' => $file['id'],
                'user_id' => $user->id,
                'path' => $path,
                'uploadable_id' => $resourceId,
            ]);
    
            Storage::disk('')->delete($path);
        }
    }


    


}
