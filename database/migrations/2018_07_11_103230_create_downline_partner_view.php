<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownlinePartnerView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_downline_partner AS 
            select
                a.product_id,
                b.product_id_partner,
                c.store_id, d.name as store_name_partner, d.photo as store_photo_partner 
            from
                product a inner join partnership_request b on
                a.product_id = b.product_id inner join product c on
                b.product_id_partner = c.product_id inner join store d on c.store_id = d.store_id
            where
                b.status = '1'
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_downline_partner");
    }
}
