<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRfqOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_offer', function (Blueprint $table) {
            $table->increments('rfq_offer_id');
            $table->integer('rfq_request_id')->nullable();
            $table->integer('store_id')->nullable();
            $table->string('description',1000)->nullable();
            $table->integer('price_unit')->nullable();
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
        Schema::dropIfExists('rfq_offer');
    }
}
