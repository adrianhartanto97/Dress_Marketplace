<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderApprovalView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_order_approval AS 
            select
                transaction_id,
                store_id, 
                sum(case when accept_status = '1' then 1 else 0 end) as \"accepted\", 
                sum(case when accept_status = '2' then 1 else 0 end) as \"rejected\"
            from
                view_order_approve_summary_product group by transaction_id, store_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_order_approval");
    }
}
