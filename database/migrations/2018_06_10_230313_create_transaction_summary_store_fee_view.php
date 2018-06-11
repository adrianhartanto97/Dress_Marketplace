<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionSummaryStoreFeeView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_transaction_summary_store_fee AS 
        select
            a.*,
            b.courier_id, c.courier_name, b.courier_service, b.fee, b.note
        from
            view_transaction_summary_store a inner join sales_transaction_shipping b on
            a.transaction_id = b.transaction_id
            and a.store_id = b.store_id inner join master_courier c on b.courier_id = c.courier_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_transaction_summary_store_fee");
    }
}
