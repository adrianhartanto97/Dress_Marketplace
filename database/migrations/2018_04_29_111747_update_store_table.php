<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store', function (Blueprint $table) {
            $table->string('name',100)->unique()->change();
            $table->string('photo',255)->nullable()->change();
            $table->string('banner',255)->nullable()->change();
            $table->string('description',1000)->nullable()->change();
            $table->string('established_year',4)->nullable()->change();
            $table->string('province',100)->nullable()->change();
            $table->string('city',100)->nullable()->change();
            $table->string('business_type',2)->nullable()->change();
            $table->string('store_active_status',1)->comment("0 : waiting admin approval, 1 : active, 2 : rejected")->change();
            $table->string('reject_comment',100)->nullable();
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store', function (Blueprint $table) {
            $table->string('photo',255)->nullable(false)->change();
            $table->string('banner',255)->nullable(false)->change();
            $table->string('description',1000)->nullable(false)->change();
            $table->string('established_year',4)->nullable(false)->change();
            $table->string('province',100)->nullable(false)->change();
            $table->string('city',100)->nullable(false)->change();
            $table->string('business_type',2)->nullable(false)->change();
            //$table->string('store_active_status',1)->comment = "0 : waiting admin approval, 1 : active, 2 : rejected"->change();
            $table->dropColumn('reject_comment');
        });
    }
}
