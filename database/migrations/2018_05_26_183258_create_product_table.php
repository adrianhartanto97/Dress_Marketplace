<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('product_id');
            $table->integer('store_id');
            $table->string('name',100);
            $table->integer('min_order')->nullable();
            $table->integer('weight')->nullable();
            $table->string('description',255)->nullable();
            $table->string('photo',100)->nullable();
            $table->integer('style_id')->nullable();
            $table->integer('season_id')->nullable();
            $table->integer('neckline_id')->nullable();
            $table->integer('sleevelength_id')->nullable();
            $table->integer('waiseline_id')->nullable();
            $table->integer('material_id')->nullable();
            $table->integer('fabrictype_id')->nullable();
            $table->integer('decoration_id')->nullable();
            $table->integer('patterntype_id')->nullable();
            $table->string('product_type',2)->nullable();
            $table->string('product_active_status',2)->nullable();
            $table->string('product_ownership',2)->nullable();
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
        Schema::dropIfExists('product');
    }
}
