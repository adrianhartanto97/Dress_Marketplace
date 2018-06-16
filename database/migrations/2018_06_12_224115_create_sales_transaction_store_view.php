<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTransactionStoreView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_sales_transaction_store AS 
        select
            a.transaction_id,
            a.user_id,
            b.store_id,
            c.store_name,
            b.order_number,
            a.address,
            c.note,
            c.courier_id,
            c.courier_name,
            c.courier_service,
            c.total_price as 'subtotal_price',
            c.fee as 'shipping_price',
            c.total_price + c.fee as 'total_price'
        from
            sales_transaction_header a inner join sales_transaction_state b on
            a.transaction_id = b.transaction_id inner join view_transaction_summary_store_fee c on
            b.transaction_id = c.transaction_id
            and b.store_id = c.store_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_sales_transaction_store");
    }
}
