<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDashboardView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_dashboard AS 
        select
            c.created_at,a.transaction_id, b.store_id, b.order_number, a.total_receive
        from
            view_order_money_movement a inner join sales_transaction_state b on
            a.transaction_id = b.transaction_id
            and a.store_id = b.store_id inner join sales_transaction_header c on
            a.transaction_id = c.transaction_id
        where
            a.status = '1'
            and cast(
                b.state as unsigned
            )> 3
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_dashboard");
    }
}
