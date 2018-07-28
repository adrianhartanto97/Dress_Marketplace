<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRfqOfferHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_rfq_offer_history AS 
        select
        a.*,
        b.user_id,
        b.item_name,
        b.description as request_description,
        b.qty,
        b.request_expired,
        b.budget_unit_min,
        b.budget_unit_max,
        b.status,
        b.accept_rfq_offer_id,
        case
            when b.status = '0' then 'Waiting User Response'
            when b.status = '1' and a.rfq_offer_id = b.accept_rfq_offer_id then 'Accepted'
            when b.status = '1' and a.rfq_offer_id <> b.accept_rfq_offer_id then 'Rejected'
            when b.status = '2' then 'Closed by User'
        end as offer_status
        from
            rfq_offer a inner join rfq_request b on
            a.rfq_request_id = b.rfq_request_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("CREATE OR REPLACE VIEW view_rfq_offer_history AS 
            select
                a.*,
                b.user_id,
                b.item_name,
                b.description as request_description,
                b.qty,
                b.request_expired,
                b.budget_unit_min,
                b.budget_unit_max
            from
                rfq_offer a inner join rfq_request b on
                a.rfq_request_id = b.rfq_request_id
        ");
    }
}
