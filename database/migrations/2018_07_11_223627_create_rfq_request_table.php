<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRfqRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_request', function (Blueprint $table) {
            $table->increments('rfq_request_id');
            $table->integer('user_id')->nullable();
            $table->string('item_name',100)->nullable();
            $table->string('description',1000)->nullable();
            $table->integer('qty')->nullable();
            $table->dateTime('request_expired')->nullable();
            $table->integer('budget_unit_min')->nullable();
            $table->integer('budget_unit_max')->nullable();
            $table->string('status',2)->nullable();
            $table->integer('accept_rfq_offer_id')->nullable();
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
        Schema::dropIfExists('rfq_request');
    }
}
