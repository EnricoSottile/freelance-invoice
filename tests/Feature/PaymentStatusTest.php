<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use \Carbon\Carbon;
use App\Helpers\PaymentStatus;

class PaymentStatusTest extends TestCase
{

    use RefreshDatabase;

    public function getUser(){
        return factory(User::class)->create();
    }

    public function getCustomer($userId){
        return factory( Customer::class )->create(['user_id' => $userId]);
    }

    public function getInvoice($userId, $customerId, $registered_date = null){
        return factory( Invoice::class )
            ->create([
                'user_id' => $userId, 
                'customer_id' => $customerId, 
                'registered_date' => $registered_date
            ]);
    }

    public function getPayment($userId, $invoiceId, $payed_date = null){
        return factory( Payment::class)
            ->create([
                'user_id' => $userId, 
                'invoice_id' => $invoiceId, 
                'payed_date' => $payed_date
            ]);
    }


    public function testPaymentCanBeDeleted(){
        $user = $this->getUser();
        $customer = $this->getCustomer($user->id);
        $invoice = $this->getInvoice($user->id, $customer->id);
        $payment = $this->getPayment($user->id, $invoice->id);

        $status = new PaymentStatus($payment);
        $this->assertTrue( $status->canBeDeleted() );
        $this->assertTrue( $status->canBeUpdated() );
    }

    public function testPaymentCannotBeDeletedBecauseIsPayed(){
        $user = $this->getUser();
        $customer = $this->getCustomer($user->id);
        $invoice = $this->getInvoice($user->id, $customer->id);
        $payment = $this->getPayment($user->id, $invoice->id, Carbon::now() );

        $status = new PaymentStatus($payment);
        $this->assertFalse( $status->canBeDeleted() );
        $this->assertFalse( $status->canBeUpdated() );
    }


}
