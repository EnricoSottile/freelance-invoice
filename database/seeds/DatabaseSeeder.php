<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Filesystem\Filesystem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        echo "Running Seeder...\n";

        $this->cleanStorage();

        // Users
        $users = factory(User::class, 25)->create();
        $users->each(function($u) {

            // Customers
            $customers = $this->createCustomer($u->id);
            $customers->each(function($c) use($u) {

                // Invoices
                $invoices = $this->createInvoices($u->id, $c->id);
                $invoices->each(function($i) use($u) {

                    // Payments
                    $payments = $this->createPayments($u->id, $i->id);

                });
            });
        });
    }

    private function cleanStorage(){
        $file = new Filesystem();
        $file->cleanDirectory('storage/app/private');
    }

 
    /** 
     *
     * @param integer $id
     * @return Collection
     */
    private function createCustomer(int $user_id) : Collection
    {
        $count = rand(3, 15);
        return factory( Customer::class, $count )
                ->create(['user_id' => $user_id]);
    }


    /** 
     *
     * @param integer $id
     * @return Collection
     */
    private function createInvoices(int $user_id, int $customer_id) : Collection
    {
        $count = rand(10, 25);
        $params = ['customer_id' => $customer_id, 'user_id' => $user_id];
        return factory( Invoice::class, $count )->create($params);
    }


    /**
     *
     * @param integer $user_id
     * @param integer $invoice_id
     * @return Collection
     */
    private function createPayments(int $user_id, int $invoice_id): Collection {
        $count = rand(1, 6);
        $params = ['user_id' => $user_id,'invoice_id' => $invoice_id];
        return factory( Payment::class, $count)->create($params);
    }


}
