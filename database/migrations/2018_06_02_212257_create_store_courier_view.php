<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreCourierView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_store_courier AS 
        select
            a.store_id, a.name, c.courier_id, c.courier_name, c.alias_name, c.logo
        from
            store a inner join store_courier_service b on
            a.store_id = b.store_id inner join master_courier c on
            b.courier_id = c.courier_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_store_courier");
    }
}
