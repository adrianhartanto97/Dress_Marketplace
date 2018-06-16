<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderApproveDetailProductView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_order_approve_detail_product AS 
        select
            a.*,
            b.accept_status
        from
            view_transaction_detail_product a inner join sales_transaction_product b on
            a.transaction_id = b.transaction_id
            and a.product_id = b.product_id
            and a.product_size_id = b.product_size_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_order_approve_detail_product");
    }
}
