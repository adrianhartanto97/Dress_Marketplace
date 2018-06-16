<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderShippingView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_order_shipping AS 
        select
            a.*,
            b.shipping_status,
            b.receipt_number,
            b.receipt_status
        from
            view_order_status a inner join sales_transaction_shipping b on
            a.transaction_id = b.transaction_id
            and a.store_id = b.store_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_order_shipping");
    }
}
