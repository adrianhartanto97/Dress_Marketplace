<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRfqOfferHistory extends Migration
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
                b.budget_unit_max
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
        DB::statement("DROP VIEW view_rfq_offer_history");
    }
}
