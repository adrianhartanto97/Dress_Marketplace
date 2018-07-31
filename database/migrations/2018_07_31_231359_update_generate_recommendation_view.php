<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGenerateRecommendationView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_generate_recommendation AS 
           select
            a.product_id as dress_id,
            a.style_id as style,
            case
                when a.source = 'D' then c.price
                when coalesce(
                    a.source,
                    'P'
                )= 'P' then 0
            end as price,
            case
                when a.source = 'D' then (c.rating + coalesce(e.sum,0)) / (coalesce(e.count,0) + 1)
                when coalesce(
                    a.source,
                    'P'
                )= 'P' then coalesce(
                    d.average_rating,
                    0
                )
            end as rating,
            b.size_id as size,
            a.season_id as season,
            a.neckline_id as neck_line,
            a.sleevelength_id as sleeve_length,
            a.waiseline_id as waist_line,
            a.material_id as material,
            a.fabrictype_id as fabric_type,
            a.decoration_id as decoration,
            a.patterntype_id as pattern_type
        from
            product a inner join product_size b on
            a.product_id = b.product_id left join data_training c on
            a.product_id = c.dress_id left join view_product_rating d on
            a.product_id = d.product_id left join view_product_rating_sum e on
            a.product_id = e.product_id
        where
            a.product_type = '0'
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("CREATE OR REPLACE VIEW view_generate_recommendation AS 
           select
                a.product_id as dress_id,
                a.style_id as style,
                case
                    when a.source = 'D' then c.price
                    when coalesce(
                        a.source,
                        'P'
                    )= 'P' then 0
                end as price,
                case
                    when a.source = 'D' then c.rating
                    when coalesce(
                        a.source,
                        'P'
                    )= 'P' then coalesce(d.average_rating,0)
                end as rating,
                b.size_id as size,
                a.season_id as season,
                a.neckline_id as neck_line,
                a.sleevelength_id as sleeve_length,
                a.waiseline_id as waist_line,
                a.material_id as material,
                a.fabrictype_id as fabric_type,
                a.decoration_id as decoration,
                a.patterntype_id as pattern_type
            from
                product a inner join product_size b on
                a.product_id = b.product_id left join data_training c on
                a.product_id = c.dress_id left join view_product_rating d on a.product_id = d.product_id
            where
                a.product_type = '0'
        ");
    }
}
