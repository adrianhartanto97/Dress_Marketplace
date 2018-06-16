<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTransactionPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_transaction_payment', function (Blueprint $table) {
            $table->integer('transaction_id');
            $table->integer('company_bank_id')->nullable();
            $table->integer('amount')->nullable();
            $table->string('sender_bank',100)->nullable();
            $table->string('sender_account_number',100)->nullable();
            $table->string('sender_name',100)->nullable();
            $table->string('note',255)->nullable();
            $table->string('status',2)->nullable();
            $table->integer('receive_amount')->nullable();
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
        Schema::dropIfExists('sales_transaction_payment');
    }
}
