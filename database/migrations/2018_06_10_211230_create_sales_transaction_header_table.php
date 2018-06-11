<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTransactionHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_transaction_header', function (Blueprint $table) {
            $table->increments('transaction_id');
            $table->integer('user_id');
            $table->string('receiver_name',100);
            $table->string('address',255);
            $table->integer('province');
            $table->integer('city');
            $table->string('phone_number',100);
            $table->string('postal_code',20)->nullable();
            $table->integer('use_point')->nullable();
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
        Schema::dropIfExists('sales_transaction_header');
    }
}
