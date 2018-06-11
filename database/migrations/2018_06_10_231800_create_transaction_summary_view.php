<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionSummaryView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_transaction_summary AS 
        select
            a.transaction_id,
            b.user_id,
            a.total_qty,
            a.total_price as 'subtotal_price',
            a.total_weight,
            a.total_fee,
            coalesce(b.use_point,0) as 'use_point',
            a.total_price + a.total_fee - coalesce(b.use_point,0) as 'total_price'
        from
            view_transaction_summary_price a inner join sales_transaction_header b on
            a.transaction_id = b.transaction_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_transaction_summary");
    }
}
