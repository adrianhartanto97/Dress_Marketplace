<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductView3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW view_product AS 
        select
            a.product_id,
            a.store_id,
            b.name as 'store_name',
            a.name as 'product_name',
            a.min_order,
            a.weight,
            a.description,
            a.photo,
            a.style_id,
            c.style_name,
            a.season_id,
            d.season_name,
            a.neckline_id,
            e.neckline_name,
            a.sleevelength_id,
            f.sleevelength_name,
            a.waiseline_id,
            g.waiseline_name,
            a.material_id,
            h.material_name,
            a.fabrictype_id,
            i.fabrictype_name,
            a.decoration_id,
            j.decoration_name,
            a.patterntype_id,
            k.patterntype_name,
            a.product_type,
            a.product_active_status,
            a.product_ownership,
            a.created_at,
            a.updated_at,
            coalesce(a.available_status,'Y') as available_status,
            case
                when a.source = 'D' then o.rating
                when coalesce(
                    a.source,
                    'P'
                )= 'P' then coalesce(
                    l.average_rating,
                    0
                )
            end as average_rating,
            coalesce(
                m.sold,
                0
            ) as sold,
            case
                when a.source = 'D' and coalesce(a.available_status,'Y')='Y' then n.max_price
                when a.source = 'D' and coalesce(a.available_status,'Y')='N' then p.price_name
                when a.source = 'P' then n.max_price
            end as max_price
        from
            product a inner join store b on
            a.store_id = b.store_id inner join product_style_attribute c on
            a.style_id = c.style_id inner join product_season_attribute d on
            a.season_id = d.season_id inner join product_neckline_attribute e on
            a.neckline_id = e.neckline_id inner join product_sleevelength_attribute f on
            a.sleevelength_id = f.sleevelength_id inner join product_waiseline_attribute g on
            a.waiseline_id = g.waiseline_id inner join product_material_attribute h on
            a.material_id = h.material_id inner join product_fabrictype_attribute i on
            a.fabrictype_id = i.fabrictype_id inner join product_decoration_attribute j on
            a.decoration_id = j.decoration_id inner join product_patterntype_attribute k on
            a.patterntype_id = k.patterntype_id left join view_product_rating l on
            a.product_id = l.product_id left join view_sold_product m on
            a.product_id = m.product_id left join view_product_first_price n on
            a.product_id = n.product_id left join data_training o on
            a.product_id = o.dress_id inner join product_price_attribute p on o.price = p.price_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("CREATE OR REPLACE VIEW view_product AS 
        select
          a.product_id,
          a.store_id,
          b.name as 'store_name',
          a.name as 'product_name',
          a.min_order,
          a.weight,
          a.description,
          a.photo,
          a.style_id,
          c.style_name,
          a.season_id,
          d.season_name,
          a.neckline_id,
          e.neckline_name,
          a.sleevelength_id,
          f.sleevelength_name,
          a.waiseline_id,
          g.waiseline_name,
          a.material_id,
          h.material_name,
          a.fabrictype_id,
          i.fabrictype_name,
          a.decoration_id,
          j.decoration_name,
          a.patterntype_id,
          k.patterntype_name,
          a.product_type,
          a.product_active_status,
          a.product_ownership,
          a.created_at,
          a.updated_at,
          coalesce(
           l.average_rating,
           0
          ) as average_rating,
          coalesce(
           m.sold,
           0
          ) as sold,
          n.max_price
         from
          product a inner join store b on
          a.store_id = b.store_id inner join product_style_attribute c on
          a.style_id = c.style_id inner join product_season_attribute d on
          a.season_id = d.season_id inner join product_neckline_attribute e on
          a.neckline_id = e.neckline_id inner join product_sleevelength_attribute f on
          a.sleevelength_id = f.sleevelength_id inner join product_waiseline_attribute g on
          a.waiseline_id = g.waiseline_id inner join product_material_attribute h on
          a.material_id = h.material_id inner join product_fabrictype_attribute i on
          a.fabrictype_id = i.fabrictype_id inner join product_decoration_attribute j on
          a.decoration_id = j.decoration_id inner join product_patterntype_attribute k on
          a.patterntype_id = k.patterntype_id left join view_product_rating l on
          a.product_id = l.product_id left join view_sold_product m on
          a.product_id = m.product_id inner join view_product_first_price n on
          a.product_id = n.product_id
        ");
    }
}
