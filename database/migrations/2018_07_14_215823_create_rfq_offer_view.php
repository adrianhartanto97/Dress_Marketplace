<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRfqOfferView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_rfq_offer AS 
            select
                a.*,
                b.name as store_name,
                b.photo as store_photo,
                b.province_name,
                b.city_name,
                c.qty,
                (
                    c.qty * a.price_unit
                ) as total_price
            from
                rfq_offer a inner join view_store_active b on
                a.store_id = b.store_id inner join rfq_request c on
                a.rfq_request_id = c.rfq_request_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_rfq_offer");
    }
}
