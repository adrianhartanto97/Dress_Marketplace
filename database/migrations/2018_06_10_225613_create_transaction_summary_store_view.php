<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionSummaryStoreView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_transaction_summary_store AS 
        select
            transaction_id,
            store_id,
            store_name,
            store_photo,
            sum( total_qty ) as 'total_qty',
            sum( price_total ) as 'total_price',
            sum( total_weight ) as 'total_weight'
        from
            view_transaction_summary_product
        group by
            transaction_id,
            store_id,
            store_name,
            store_photo
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_transaction_summary_store");
    }
}
