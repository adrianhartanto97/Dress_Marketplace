<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionSummaryProductView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_transaction_summary_product AS 
        select
            transaction_id,
            store_id,
            store_name,
            store_photo,
            product_id,
            product_name,
            product_photo,
            sum( product_qty ) as 'total_qty',
            get_price_per_product(product_id, sum(product_qty)) as 'price_unit',
            get_price_per_product(product_id, sum(product_qty)) * sum( product_qty ) as 'price_total',
            sum( product_qty * weight) as 'total_weight' 
        from
            view_transaction_detail_product
        group by
            transaction_id,
            store_id,
            store_name,
            store_photo,
            product_id,
            product_name,
            product_photo;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_transaction_summary_product");
    }
}
