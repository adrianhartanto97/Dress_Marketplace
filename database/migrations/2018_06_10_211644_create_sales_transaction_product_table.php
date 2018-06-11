<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTransactionProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_transaction_product', function (Blueprint $table) {
            $table->integer('transaction_id');
            $table->integer('product_id');
            $table->integer('product_size_id');
            $table->integer('product_qty');
            $table->string('accept_status',2)->nullable();
            $table->string('reject_comment',255)->nullable();
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
        Schema::dropIfExists('sales_transaction_product');
    }
}
