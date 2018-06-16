<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderMoneyMovementView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_order_money_movement AS 
        select
            a.transaction_id,
            b.user_id as 'buyer_id',
            a.store_id,
            c.user_id as 'seller_id',
            a.store_name,
            a.store_photo,
            a.accept_status,
            a.total_qty,
            a.total_price,
            a.total_weight,
            case
                when a.accept_status = '1' then d.shipping_price
                when a.accept_status = '2' then '0'
            end as 'shipping_price',
            a.total_price +(
                case
                    when a.accept_status = '1' then d.shipping_price
                    when a.accept_status = '2' then '0' end
            ) as 'total_receive'
        from
            view_order_approve_summary_store a inner join sales_transaction_header b on
            a.transaction_id = b.transaction_id inner join store c on
            a.store_id = c.store_id inner join view_sales_transaction_store d on
            a.transaction_id = d.transaction_id
            and a.store_id = d.store_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_order_money_movement");
    }
}
