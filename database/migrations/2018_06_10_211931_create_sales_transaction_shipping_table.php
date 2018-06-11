<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTransactionShippingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_transaction_shipping', function (Blueprint $table) {
            $table->integer('transaction_id');
            $table->integer('store_id');
            $table->integer('courier_id');
            $table->string('courier_service',20);
            $table->integer('fee');
            $table->string('note',255)->nullable();
            $table->string('shipping_status',2)->nullable();
            $table->string('receipt_number',255)->nullable();
            $table->string('receipt_status',2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_transaction_shipping');
    }
}
