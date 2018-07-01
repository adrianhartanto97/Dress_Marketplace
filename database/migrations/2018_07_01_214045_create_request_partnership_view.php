<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestPartnershipView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_request_partnership AS 
            select
                a.*,
                b.product_id_partner,
                b.min_order,
                b.status,
                c.store_id as store_id_partner
            from
                view_order_approve_summary_product a inner join partnership_request b on
                a.product_id = b.product_id inner join product c on
                b.product_id_partner = c.product_id where accept_status = '1'
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_request_partnership");
    }
}
