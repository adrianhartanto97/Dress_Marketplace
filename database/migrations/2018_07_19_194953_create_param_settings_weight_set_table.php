<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParamSettingsWeightSetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('param_settings_weight_set', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('node_i')->nullable();
            $table->integer('node_j')->nullable();
            $table->decimal('weight',12,10)->nullable();
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
        Schema::dropIfExists('param_settings_weight_set');
    }
}
