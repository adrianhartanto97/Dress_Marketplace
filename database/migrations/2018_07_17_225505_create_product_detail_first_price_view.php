<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDetailFirstPriceView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::statement("CREATE OR REPLACE VIEW view_product_detail_first_price AS 
            select
                a.*,
                b.max_price
               
            from
                view_product a inner join view_product_first_price b on
                a.product_id = b.product_id 
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_product_detail_first_price");
    }
}
