<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilterView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_filter_courier AS 
        SELECT 
            a.product_id,
            a.store_id,
            a.store_name,
            a.product_name,
            a.min_order,
            a.weight,
            a.description,a.photo,
            a.average_rating as product_rating, a.sold, 
            a.max_price, b.province,b.city,c.courier_id
        FROM view_product a inner JOIN store b ON
            a.store_id = b.store_id INNER JOIN store_courier_service c ON
            b.store_id = c.store_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         DB::statement("DROP VIEW view_filter_courier");

    }
}
