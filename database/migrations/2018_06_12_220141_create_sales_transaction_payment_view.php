<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTransactionPaymentView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_sales_transaction_payment AS 
        select
            a.transaction_id,
            a.user_id,
            a.total_price as 'invoice_grand_total',
            date(b.created_at) as 'invoice_date',
            case
                when coalesce(c.status,'') ='' then 'Waiting for Payment'
                when c.status = '0' then 'Payment Confirmation Sent'
                when c.status = '1' then 'Accept'
                when c.status = '2' then 'Reject'
            end as 'payment_status',
            c.company_bank_id,
            c.amount,
            c.sender_bank,
            c.sender_account_number,
            c.sender_name,
            c.note,
            c.receive_amount,
            c.reject_comment
        from
            view_transaction_summary a inner join sales_transaction_header b on
            a.transaction_id = b.transaction_id left join sales_transaction_payment c on
            a.transaction_id = c.transaction_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_sales_transaction_payment");
    }
}
