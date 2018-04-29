<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreBankAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_bank_account', function (Blueprint $table) {
            $table->integer('store_id');
            $table->string('bank_name',100);
            $table->string('branch',100);
            $table->string('bank_account_number',100);
            $table->string('name_in_bank',100);
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
        Schema::dropIfExists('store_bank_account');
    }
}
