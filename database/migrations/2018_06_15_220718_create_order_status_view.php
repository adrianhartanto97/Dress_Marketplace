<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatusView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_order_status AS 
        select
            a.transaction_id,
            a.store_id,
            d.name as 'store_name',
            a.order_number,
            date(c.created_at) as 'invoice_date',
            a.state,
            case
                when g.status = '0' then 'Waiting Seller Response'
                when g.status = '1' then 'Order Approved'
            end as 'order_status',
            c.user_id,
            c.receiver_name,
            c.address,
            c.province, e.province_name,
            c.city, f.city_name,
            c.phone_number,
            c.postal_code,
            b.courier_id,
            b.courier_name,
            b.courier_service,
            b.note,
            b.total_qty,
            b.total_weight,
            b.total_price as 'subtotal_price',
            b.fee as 'shipping_price',
            b.total_price + b.fee as 'total_price'
        from
            sales_transaction_state a inner join view_transaction_summary_store_fee b on
            a.transaction_id = b.transaction_id
            and a.store_id = b.store_id inner join sales_transaction_header c on
            a.transaction_id = c.transaction_id inner join store d on
            a.store_id = d.store_id inner join master_province e on
            c.province = e.province_id inner join master_city f on
            c.city = f.city_id inner join sales_transaction_order_status g on a.transaction_id = g.transaction_id
            and a.store_id = g.store_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_order_status");
    }
}
