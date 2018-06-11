<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyBankAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_bank_account', function (Blueprint $table) {
            $table->integer('bank_id');
            $table->string('bank_name',100);
            $table->string('branch',50);
            $table->string('account_number',50);
            $table->string('name_in_account',100);
            $table->string('logo',100);
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
        Schema::dropIfExists('company_bank_account');
    }
}
