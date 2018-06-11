<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCartDetailView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_cart_detail AS 
        select
            a.user_id, e.store_id, e.name as 'store_name',e.photo as 'store_photo', a.product_id, d.name as 'product_name', d.photo as 'product_photo', d.weight, a.product_size_id, b.size_name, a.product_qty, a.created_at, a.updated_at
        from
            cart a inner join product_size_attribute b on
            a.product_size_id = b.size_id inner join product d on
            a.product_id = d.product_id inner join store e on d.store_id = e.store_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_cart_detail");
    }
}
