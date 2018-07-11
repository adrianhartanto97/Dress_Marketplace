<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUplinePartnerView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_upline_partner AS 
            select
                a.partnership_id,
                a.product_id_partner,
                a.product_id as upline_product_id,
                c.name as store_name_upline,
                c.photo as store_photo_upline
            from
                partnership_request a inner join product b on
                a.product_id = b.product_id inner join store c on
                b.store_id = c.store_id
            where a.status = '1'
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_upline_partner");
    }
}
