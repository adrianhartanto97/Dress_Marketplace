<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderApproveDummyView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_order_approve_dummy AS 
        select
			transaction_id,
			store_id,
			'0' as 'status'
            from
                view_order_status
        union all select
                transaction_id,
                store_id,
                '1' as 'status'
            from
                view_order_status
        union all select
                transaction_id,
                store_id,
                '2' as 'status'
            from
                view_order_status
            order by
                transaction_id,
                store_id,
                status
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_order_approve_dummy");
    }
}
