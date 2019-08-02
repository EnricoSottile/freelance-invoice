<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('number');
            $table->decimal('net_amount', 10,2)->default(0.00);
            $table->decimal('tax', 5,2)->default(0.00);
            $table->longText('description')->nullable();

            $table->dateTime('date')->nullable();
            $table->dateTime('sent_date')->nullable();
            $table->dateTime('registered_date')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
