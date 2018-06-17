<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderMoneyMovementView extends Migration
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
                sub.transaction_id,
                b.user_id as 'buyer_id',
                sub.store_id,
                c.user_id as 'seller_id',
                sub.status,
                coalesce(
                    a.total_qty,
                    0
                ) as 'total_qty',
                coalesce(
                    a.total_price,
                    0
                ) as 'total_price',
                coalesce(
                    a.total_weight,
                    0
                ) as 'total_weight',
                case
                    when sub.status = '0' then 0
                    when sub.status = '1' then d.shipping_price
                    when sub.status = '2' then 0
                end as 'shipping_price',
                coalesce(
                    a.total_price,
                    0
                )+(
                    case
                        when sub.status = '0' then 0
                        when sub.status = '1' then d.shipping_price
                        when sub.status = '2' then 0
                    end
                ) as 'total_receive'
            from
                view_order_approve_dummy as sub left join view_order_approve_summary_store a on
                sub.transaction_id = a.transaction_id
                and sub.store_id = a.store_id
                and sub.status = a.accept_status inner join sales_transaction_header b on
                sub.transaction_id = b.transaction_id inner join store c on
                sub.store_id = c.store_id inner join view_sales_transaction_store d on
                sub.transaction_id = d.transaction_id
                and sub.store_id = d.store_id
            order by
                sub.transaction_id,
                sub.store_id,
                sub.status;
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
