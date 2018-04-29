<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store', function (Blueprint $table) {
            $table->increments('store_id');
            $table->integer('user_id');
            $table->string('name',100);
            $table->string('photo',255);
            $table->string('banner',255);
            $table->string('description',1000);
            $table->string('established_year',4);
            $table->string('province',100);
            $table->string('city',100);
            $table->string('business_type',2);
            $table->string('contact_person_name',255)->nullable();
            $table->string('contact_person_job_title',255)->nullable();
            $table->string('contact_person_phone_number',30)->nullable();
            $table->string('store_active_status',1);
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
        Schema::dropIfExists('store');
    }
}
