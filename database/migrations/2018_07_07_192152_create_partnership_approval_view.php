<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnershipApprovalView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_partnership_approval AS 
            select
                a.*, b.name as product_name, b.photo, 
                b.store_id, e.name as store_name,
                c.store_id as store_id_partner, d.name as store_name_partner
            from
                partnership_request a inner join product b on
                a.product_id = b.product_id inner join product c on
                a.product_id_partner = c.product_id inner join store d on
                c.store_id = d.store_id inner join store e on b.store_id = e.store_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_partnership_approval");
    }
}
