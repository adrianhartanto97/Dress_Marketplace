<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductReviewRatingView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_product_review_rating AS 
            select
                a.*,
                b.user_id,
                c.email,
                c.full_name,
                CASE WHEN COALESCE(c.avatar,'') = '' THEN 'profile_image/default.png' ELSE c.avatar END as avatar
            from
                sales_transaction_product_review_rating a inner join sales_transaction_header b on
                a.transaction_id = b.transaction_id inner join `user` c on
                b.user_id = c.user_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_product_review_rating");
    }
}
