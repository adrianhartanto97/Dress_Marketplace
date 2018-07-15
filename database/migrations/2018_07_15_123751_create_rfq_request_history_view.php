<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRfqRequestHistoryView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_rfq_request_history AS 
            select
            *,
            case
                when status = '0'
                and request_expired <= now() then 'Request Expired'
                when status = '1' then 'Accepted'
                when status = '2' then 'Closed' end as rfq_status
            from
                rfq_request
            where
                (
                    status = '0'
                    and request_expired <= now()
                )
                or status = '1'
                or status = '2'
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_rfq_request_history");
    }
}
