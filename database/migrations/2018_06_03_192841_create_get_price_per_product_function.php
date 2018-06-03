<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGetPricePerProductFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            DROP FUNCTION IF EXISTS get_price_per_product;
            CREATE FUNCTION get_price_per_product(p_product_id int, p_qty int) RETURNS INT
            BEGIN
                DECLARE res INT;
                select
                price into res
                from
                    product_price
                where
                    product_id = p_product_id and ((qty_max <> 'max' and p_qty >= qty_min and p_qty <= qty_max) or  (qty_max = 'max' and p_qty >= qty_min ));
                RETURN (coalesce(res,0));
            END;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP FUNCTION IF EXISTS get_price_per_product;");
    }
}
