<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParamSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('param_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('random_seed')->nullable();
            $table->integer('param_firefly')->nullable();
            $table->integer('param_maks_epoch_ffa')->nullable();
            $table->decimal('param_base_beta',12,10)->nullable();
            $table->decimal('param_gamma',12,10)->nullable();
            $table->decimal('param_alpha',12,10)->nullable();
            $table->integer('param_maks_epoch_psnn')->nullable();
            $table->integer('param_summing_units')->nullable();
            $table->decimal('param_learning_rate',12,10)->nullable();
            $table->decimal('param_momentum',12,10)->nullable();
            $table->decimal('rmse',12,10)->nullable();
            $table->integer('status_use')->nullable();
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
        Schema::dropIfExists('param_settings');
    }
}
