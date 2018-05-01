<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreSupportingDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_supporting_documents', function (Blueprint $table) {
            $table->integer('store_id')->primary();
            $table->string('ktp',100)->nullable();
            $table->string('siup',100)->nullable();
            $table->string('npwp',100)->nullable();
            $table->string('skdp',100)->nullable();
            $table->string('tdp',100)->nullable();
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
        Schema::dropIfExists('store_supporting_documents');
    }
}
