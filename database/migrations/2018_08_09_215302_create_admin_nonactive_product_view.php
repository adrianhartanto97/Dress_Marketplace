<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminNonactiveProductView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_admin_nonactive_product AS 
        select
            a.product_id,
            a.name as product_name,
            a.photo as product_photo,
            b.name as store_name
        from
            product a inner join store b on
            a.store_id = b.store_id
        where
            a.product_active_status = '2'
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_admin_nonactive_product");
    }
}
