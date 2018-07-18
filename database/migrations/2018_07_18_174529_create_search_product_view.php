<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchProductView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_search_product AS 
           SELECT 
                a.product_id,
                a.product_name,
                a.min_order,
                a.photo,
                a.max_price,
                a.average_rating,   
                b.province_id,
                b.province_name,
                b.city_id, 
                b.city_name,
                a.created_at,
                a.updated_at
               
            FROM
                view_product_detail_first_price a  INNER JOIN  view_store_active b ON
                a.store_id = b.store_id

        ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_search_product");
    }
}
