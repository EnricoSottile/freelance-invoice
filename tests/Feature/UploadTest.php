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
    private $invoice;

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
        ]);

        $this->invoice = $invoice;
    }


    /**
     * Test files can be uploaded
     *
     * @return void
     */
    public function testInvoiceUpload(){
        $user = $this->user;
        $invoiceId = $this->invoice->id;

        $response = $this->actingAs($user)->json('POST', "/app/upload/invoice/${invoiceId}", [
            'image' => UploadedFile::fake()->image('')
        ]);

        $file = $response->getOriginalContent()['uploads'][0];
        $path = $file['path'];
        Storage::disk('')->assertExists( $path );
        $this->assertDatabaseHas('uploads', [
            'id' => $file['id'],
            'user_id' => $user->id,
            'path' => $path,
            'uploadable_id' => $invoiceId,
        ]);

        Storage::disk('')->delete($path);
    }


}
