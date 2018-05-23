<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreActiveView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_store_active AS 
        select
	    a.store_id,a.user_id, a.name, a.photo, a.banner, a.description, a.established_year, c.province_id, c.province_name, d.city_id, d.city_name, a.business_type, a.contact_person_name, a.contact_person_job_title, a.contact_person_phone_number, a.created_at, a.updated_at, b.ktp, b.siup, b.npwp, b.skdp, b.tdp
        from
        store a inner join store_supporting_documents b on
        a.store_id = b.store_id inner join master_province c on a.province = c.province_id inner join master_city d on a.city = d.city_id
        where a.store_active_status = '1'
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_store_active");
    }
}
