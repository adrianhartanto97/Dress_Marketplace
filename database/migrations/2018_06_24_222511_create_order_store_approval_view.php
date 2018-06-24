<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStoreApprovalView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_order_store_approval AS 
            select
                a.transaction_id,
                a.store_id,
                a.store_name,
                c.photo as store_photo,
                order_number,
                a.invoice_date,
                a.state,
                a.user_id,
                b.accepted,
                b.rejected
            from
                view_order_status a inner join view_order_approval b on
                a.transaction_id = b.transaction_id
                and a.store_id = b.store_id inner join store c on a.store_id = c.store_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_order_store_approval");
    }
}
