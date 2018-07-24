<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductRecommendationView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_product_recommendation AS 
        select
            a.product_id,
            a.store_id,
            b.name as 'store_name',
            a.name as 'product_name',
            a.photo,
            a.product_type,
            a.product_active_status,
            a.product_ownership,
            a.created_at,
            a.updated_at,
            coalesce(
                a.available_status,
                'Y'
            ) as available_status,
            case
                when a.source = 'D' then e.rating
                when coalesce(
                    a.source,
                    'P'
                )= 'P' then coalesce(
                    c.average_rating,
                    0
                )
            end as average_rating,
            case
                when a.source = 'D'
                and coalesce(
                    a.available_status,
                    'Y'
                )= 'Y' then d.max_price
                when a.source = 'D'
                and coalesce(
                    a.available_status,
                    'Y'
                )= 'N' then f.price_name
                when coalesce(
                    a.source,
                    'P'
                )= 'P' then d.max_price
            end as max_price,
            g.recommendation
        from
            product a inner join store b on
            a.store_id = b.store_id left join view_product_rating c on
            a.product_id = c.product_id left join view_product_first_price d on
            a.product_id = d.product_id left join data_training e on
            a.product_id = e.dress_id left join product_price_attribute f on
            e.price = f.price_id left join view_product_size_recommendation g on
            a.product_id = g.product_id
        where
            a.product_type = '0'
            and a.product_active_status = '1'
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_product_recommendation");
    }
}
