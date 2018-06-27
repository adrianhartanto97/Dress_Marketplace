<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTransactionProductReviewRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_transaction_product_review_rating', function (Blueprint $table) {
            $table->integer('transaction_id');
            $table->integer('product_id')->nullable();
            $table->integer('rating')->nullable();
            $table->string('review',1000)->nullable();
            $table->string('status',2)->nullable();
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
        Schema::dropIfExists('sales_transaction_product_review_rating');
    }
}
