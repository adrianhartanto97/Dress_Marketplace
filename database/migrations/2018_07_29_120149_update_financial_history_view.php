<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinancialHistoryView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_financial_history AS 
            select
                year(c.created_at) as year,
                month(c.created_at) as month,
                'SALES' as transaction_code,
                'DB' as transaction_status,
                11 as priority,
                b.order_number as transaction_number,
                c.created_at as transaction_date,
                b.order_number as reference_number,
                a.seller_id as user_id,
                a.total_receive as amount,
                '' as note
            from
                view_order_money_movement a inner join sales_transaction_state b on
                a.transaction_id = b.transaction_id
                and a.store_id = b.store_id inner join sales_transaction_header c on
                a.transaction_id = c.transaction_id 
            where
                a.status = '1' and CAST(b.state AS UNSIGNED) > 3
            union all select
                year(b.created_at) as year,
                month(b.created_at) as month,
                'PAYMENT-ACCEPT' as transaction_code,
                'DB' as transaction_status,
                12 as priority,
                a.transaction_id as transaction_number,
                b.created_at as transaction_date,
                a.transaction_id as reference_number,
                a.user_id as user_id,
                (
                    a.receive_amount - a.invoice_grand_total
                ) as amount,
                '' as note
            from
                view_sales_transaction_payment a inner join sales_transaction_payment b on
                a.transaction_id = b.transaction_id
            where
                a.receive_amount - a.invoice_grand_total > 0
                and a.payment_status = 'Accept'
            union all select
                year(b.created_at) as year,
                month(b.created_at) as month,
                'PAYMENT-REJECT' as transaction_code,
                'DB' as transaction_status,
                13 as priority,
                a.transaction_id as transaction_number,
                b.created_at as transaction_date,
                a.transaction_id as reference_number,
                a.user_id as user_id,
                a.receive_amount as amount,
                b.reject_comment as note
            from
                view_sales_transaction_payment a inner join sales_transaction_payment b on
                a.transaction_id = b.transaction_id
            where
                a.receive_amount > 0
                and a.payment_status = 'Reject'
            union all select
                year(c.created_at) as year,
                month(c.created_at) as month,
                'SALES-REJECT' as transaction_code,
                'DB' as transaction_status,
                14 as priority,
                b.order_number as transaction_number,
                c.created_at as transaction_date,
                b.order_number as reference_number,
                a.buyer_id as user_id,
                a.total_receive as amount,
                '' as note
            from
                view_order_money_movement a inner join sales_transaction_state b on
                a.transaction_id = b.transaction_id
                and a.store_id = b.store_id inner join sales_transaction_header c on
                a.transaction_id = c.transaction_id
            where
                a.status = '2'
                and a.total_receive > 0 and CAST(b.state AS UNSIGNED) > 3
            union all select
                year(created_at) as year,
                month(created_at) as month,
                'USE-CASH' as transaction_code,
                'CR' as transaction_status,
                21 as priority,
                transaction_id as transaction_number,
                created_at as transaction_date,
                transaction_id as reference_number,
                user_id as user_id,
                use_point as amount,
                '' as note
            from
                sales_transaction_header
            where
                use_point > 0
            union all select
                year(created_at) as year,
                month(created_at) as month,
                'WITHDRAW' as transaction_code,
                'CR' as transaction_status,
                22 as priority,
                'WITHDRAW' as transaction_number,
                created_at as transaction_date,
                'WITHDRAW' as reference_number,
                user_id as user_id,
                amount as amount,
                '' as note
            from
                withdraw
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("CREATE OR REPLACE VIEW view_financial_history AS 
            select
                year(c.created_at) as year,
                month(c.created_at) as month,
                'SALES' as transaction_code,
                'DB' as transaction_status,
                11 as priority,
                b.order_number as transaction_number,
                c.created_at as transaction_date,
                b.order_number as reference_number,
                a.seller_id as user_id,
                a.total_receive as amount,
                '' as note
            from
                view_order_money_movement a inner join sales_transaction_state b on
                a.transaction_id = b.transaction_id
                and a.store_id = b.store_id inner join sales_transaction_header c on
                a.transaction_id = c.transaction_id 
            where
                a.status = '1' and CAST(b.state AS UNSIGNED) > 3
            union all select
                year(b.created_at) as year,
                month(b.created_at) as month,
                'PAYMENT-ACCEPT' as transaction_code,
                'DB' as transaction_status,
                12 as priority,
                a.transaction_id as transaction_number,
                b.created_at as transaction_date,
                a.transaction_id as reference_number,
                a.user_id as user_id,
                (
                    a.receive_amount - a.invoice_grand_total
                ) as amount,
                '' as note
            from
                view_sales_transaction_payment a inner join sales_transaction_payment b on
                a.transaction_id = b.transaction_id
            where
                a.receive_amount - a.invoice_grand_total > 0
                and a.payment_status = 'Accept'
            union all select
                year(b.created_at) as year,
                month(b.created_at) as month,
                'PAYMENT-REJECT' as transaction_code,
                'DB' as transaction_status,
                13 as priority,
                a.transaction_id as transaction_number,
                b.created_at as transaction_date,
                a.transaction_id as reference_number,
                a.user_id as user_id,
                a.receive_amount as amount,
                b.reject_comment as note
            from
                view_sales_transaction_payment a inner join sales_transaction_payment b on
                a.transaction_id = b.transaction_id
            where
                a.receive_amount > 0
                and a.payment_status = 'Reject'
            union all select
                year(c.created_at) as year,
                month(c.created_at) as month,
                'SALES-REJECT' as transaction_code,
                'DB' as transaction_status,
                14 as priority,
                b.order_number as transaction_number,
                c.created_at as transaction_date,
                b.order_number as reference_number,
                a.buyer_id as user_id,
                a.total_receive as amount,
                '' as note
            from
                view_order_money_movement a inner join sales_transaction_state b on
                a.transaction_id = b.transaction_id
                and a.store_id = b.store_id inner join sales_transaction_header c on
                a.transaction_id = c.transaction_id
            where
                a.status = '2'
                and a.total_receive > 0 and CAST(b.state AS UNSIGNED) > 3
            union all select
                year(created_at) as year,
                month(created_at) as month,
                'USE-POINT' as transaction_code,
                'CR' as transaction_status,
                21 as priority,
                transaction_id as transaction_number,
                created_at as transaction_date,
                transaction_id as reference_number,
                user_id as user_id,
                use_point as amount,
                '' as note
            from
                sales_transaction_header
            where
                use_point > 0
            union all select
                year(created_at) as year,
                month(created_at) as month,
                'WITHDRAW' as transaction_code,
                'CR' as transaction_status,
                22 as priority,
                'WITHDRAW' as transaction_number,
                created_at as transaction_date,
                'WITHDRAW' as reference_number,
                user_id as user_id,
                amount as amount,
                '' as note
            from
                withdraw
        ");
    }
}
