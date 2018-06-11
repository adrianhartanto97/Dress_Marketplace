<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionSummaryPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_transaction_summary_price AS 
        select
            transaction_id,
            sum(total_qty) as 'total_qty',
            sum(total_price) as 'total_price',
            sum(total_weight) as 'total_weight',
            sum(fee) as 'total_fee' 
        from
            view_transaction_summary_store_fee group by transaction_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_transaction_summary_price");
    }
}
