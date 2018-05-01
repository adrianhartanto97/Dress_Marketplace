<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStoreView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_user_store AS 
        select
            a.user_id,
            a.email,
            a.full_name,
            b.store_id,
            b.name as 'store_name',
            b.photo,
            b.banner,
            b.description,
            b.established_year,
            b.province,
            b.city,
            b.business_type,
            b.contact_person_name,
            b.contact_person_job_title,
            b.contact_person_phone_number,
            b.store_active_status,
            b.reject_comment
        from
            user a inner join store b on
            a.user_id = b.user_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_user_store");
    }
}
