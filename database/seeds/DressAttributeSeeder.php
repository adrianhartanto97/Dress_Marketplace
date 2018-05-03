<?php

use Illuminate\Database\Seeder;

class DressAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_style_attribute')->delete();
        DB::table('product_price_attribute')->delete();
        DB::table('product_size_attribute')->delete();
        DB::table('product_season_attribute')->delete();
        DB::table('product_neckline_attribute')->delete();
        DB::table('product_sleevelength_attribute')->delete();
        DB::table('product_waiseline_attribute')->delete();
        DB::table('product_material_attribute')->delete();
        DB::table('product_fabrictype_attribute')->delete();
        DB::table('product_decoration_attribute')->delete();
        DB::table('product_patterntype_attribute')->delete();

        DB::table('product_style_attribute')->insert([
            ['style_id' => 1, 'style_name' => 'bohemia', 'created_at'=> new \dateTime],
            ['style_id' => 2, 'style_name' => 'brief', 'created_at'=> new \dateTime],
            ['style_id' => 3, 'style_name' => 'casual','created_at'=> new \dateTime],
            ['style_id' => 4, 'style_name' => 'cute', 'created_at'=> new \dateTime],
            ['style_id' => 5, 'style_name' => 'fashion','created_at'=> new \dateTime],
            ['style_id' => 6, 'style_name' => 'flare', 'created_at'=> new \dateTime],
            ['style_id' => 7, 'style_name' => 'novelty', 'created_at'=> new \dateTime],
            ['style_id' => 8, 'style_name' => 'OL', 'created_at'=> new \dateTime],
            ['style_id' => 9, 'style_name' => 'party', 'created_at'=> new \dateTime],
            ['style_id' => 10, 'style_name' => 'sexy', 'created_at'=> new \dateTime],
            ['style_id' => 11, 'style_name' => 'vintage', 'created_at'=> new \dateTime],
            ['style_id' => 12, 'style_name' => 'work', 'created_at'=> new \dateTime]
        ]);

        DB::table('product_price_attribute')->insert([
            ['price_id' => 1, 'price_name' => 'low', 'created_at'=> new \dateTime],
            ['price_id' => 2, 'price_name' => 'average', 'created_at'=> new \dateTime],
            ['price_id' => 3, 'price_name' => 'medium', 'created_at'=> new \dateTime],
            ['price_id' => 4, 'price_name' => 'high', 'created_at'=> new \dateTime],
            ['price_id' => 5, 'price_name' => 'very-high', 'created_at'=> new \dateTime]
        ]);

        DB::table('product_size_attribute')->insert([
            ['size_id' => 1, 'size_name' => 'S', 'created_at'=> new \dateTime],
            ['size_id' => 2, 'size_name' => 'M', 'created_at'=> new \dateTime],
            ['size_id' => 3, 'size_name' => 'L', 'created_at'=> new \dateTime],
            ['size_id' => 4, 'size_name' => 'XL', 'created_at'=> new \dateTime],
            ['size_id' => 5, 'size_name' => 'free', 'created_at'=> new \dateTime]
        ]);

        DB::table('product_season_attribute')->insert([
            ['season_id' => 1, 'season_name' => 'autumn', 'created_at'=> new \dateTime],
            ['season_id' => 2, 'season_name' => 'winter', 'created_at'=> new \dateTime],
            ['season_id' => 3, 'season_name' => 'spring', 'created_at'=> new \dateTime],
            ['season_id' => 4, 'season_name' => 'summer', 'created_at'=> new \dateTime]
        ]);

        DB::table('product_neckline_attribute')->insert([
            ['neckline_id' => 1, 'neckline_name' => 'o-neck', 'created_at'=> new \dateTime],
            ['neckline_id' => 2, 'neckline_name' => 'backless', 'created_at'=> new \dateTime],
            ['neckline_id' => 3, 'neckline_name' => 'boat-neck', 'created_at'=> new \dateTime],
            ['neckline_id' => 4, 'neckline_name' => 'bowneck', 'created_at'=> new \dateTime],
            ['neckline_id' => 5, 'neckline_name' => 'halter', 'created_at'=> new \dateTime],
            ['neckline_id' => 6, 'neckline_name' => 'mandarin-collar', 'created_at'=> new \dateTime],
            ['neckline_id' => 7, 'neckline_name' => 'open', 'created_at'=> new \dateTime],
            ['neckline_id' => 8, 'neckline_name' => 'peterpan-collar', 'created_at'=> new \dateTime],
            ['neckline_id' => 9, 'neckline_name' => 'ruffled', 'created_at'=> new \dateTime],
            ['neckline_id' => 10, 'neckline_name' => 'scoop', 'created_at'=> new \dateTime],
            ['neckline_id' => 11, 'neckline_name' => 'splash-neck', 'created_at'=> new \dateTime],
            ['neckline_id' => 12, 'neckline_name' => 'square-collar', 'created_at'=> new \dateTime],
            ['neckline_id' => 13, 'neckline_name' => 'sweetheart', 'created_at'=> new \dateTime],
            ['neckline_id' => 14, 'neckline_name' => 'turndowncollar', 'created_at'=> new \dateTime],
            ['neckline_id' => 15, 'neckline_name' => 'v-neck', 'created_at'=> new \dateTime]
        ]);

        DB::table('product_sleevelength_attribute')->insert([
            ['sleevelength_id' => 1, 'sleevelength_name' => 'full', 'created_at'=> new \dateTime],
            ['sleevelength_id' => 2, 'sleevelength_name' => 'halfsleeves', 'created_at'=> new \dateTime],
            ['sleevelength_id' => 3, 'sleevelength_name' => 'butterfly', 'created_at'=> new \dateTime],
            ['sleevelength_id' => 4, 'sleevelength_name' => 'sleeveless', 'created_at'=> new \dateTime],
            ['sleevelength_id' => 5, 'sleevelength_name' => 'short', 'created_at'=> new \dateTime],
            ['sleevelength_id' => 6, 'sleevelength_name' => 'threquarter', 'created_at'=> new \dateTime],
            ['sleevelength_id' => 7, 'sleevelength_name' => 'turndowncollar', 'created_at'=> new \dateTime],
            ['sleevelength_id' => 8, 'sleevelength_name' => 'capsleeve', 'created_at'=> new \dateTime],
            ['sleevelength_id' => 9, 'sleevelength_name' => 'petal', 'created_at'=> new \dateTime]
        ]);

        DB::table('product_waiseline_attribute')->insert([
            ['waiseline_id' => 1, 'waiseline_name' => 'dropped', 'created_at'=> new \dateTime],
            ['waiseline_id' => 2, 'waiseline_name' => 'empire', 'created_at'=> new \dateTime],
            ['waiseline_id' => 3, 'waiseline_name' => 'natural', 'created_at'=> new \dateTime],
            ['waiseline_id' => 4, 'waiseline_name' => 'princess', 'created_at'=> new \dateTime]
        ]);

        DB::table('product_material_attribute')->insert([
            ['material_id' => 1, 'material_name' => 'microfiber', 'created_at'=> new \dateTime],
            ['material_id' => 2, 'material_name' => 'polyster', 'created_at'=> new \dateTime],
            ['material_id' => 3, 'material_name' => 'silk', 'created_at'=> new \dateTime],
            ['material_id' => 4, 'material_name' => 'chiffonfabric', 'created_at'=> new \dateTime],
            ['material_id' => 5, 'material_name' => 'cotton', 'created_at'=> new \dateTime],
            ['material_id' => 6, 'material_name' => 'nylon', 'created_at'=> new \dateTime],
            ['material_id' => 7, 'material_name' => 'milksilk', 'created_at'=> new \dateTime],
            ['material_id' => 8, 'material_name' => 'linen', 'created_at'=> new \dateTime],
            ['material_id' => 9, 'material_name' => 'rayon', 'created_at'=> new \dateTime],
            ['material_id' => 10, 'material_name' => 'lycra', 'created_at'=> new \dateTime],
            ['material_id' => 11, 'material_name' => 'acrylic', 'created_at'=> new \dateTime],
            ['material_id' => 12, 'material_name' => 'spandex', 'created_at'=> new \dateTime],
            ['material_id' => 13, 'material_name' => 'lace', 'created_at'=> new \dateTime],
            ['material_id' => 14, 'material_name' => 'modal', 'created_at'=> new \dateTime],
            ['material_id' => 15, 'material_name' => 'cashmere', 'created_at'=> new \dateTime],
            ['material_id' => 16, 'material_name' => 'viscos', 'created_at'=> new \dateTime],
            ['material_id' => 17, 'material_name' => 'knitting', 'created_at'=> new \dateTime],
            ['material_id' => 18, 'material_name' => 'sill', 'created_at'=> new \dateTime],
            ['material_id' => 19, 'material_name' => 'wool', 'created_at'=> new \dateTime],
            ['material_id' => 20, 'material_name' => 'mix', 'created_at'=> new \dateTime]
        ]);

        DB::table('product_fabrictype_attribute')->insert([
            ['fabrictype_id' => 1, 'fabrictype_name' => 'chiffon', 'created_at'=> new \dateTime],
            ['fabrictype_id' => 2, 'fabrictype_name' => 'broadcloth', 'created_at'=> new \dateTime],
            ['fabrictype_id' => 3, 'fabrictype_name' => 'jersey', 'created_at'=> new \dateTime],
            ['fabrictype_id' => 4, 'fabrictype_name' => 'batik', 'created_at'=> new \dateTime],
            ['fabrictype_id' => 5, 'fabrictype_name' => 'satin', 'created_at'=> new \dateTime],
            ['fabrictype_id' => 6, 'fabrictype_name' => 'flanner', 'created_at'=> new \dateTime],
            ['fabrictype_id' => 7, 'fabrictype_name' => 'worsted', 'created_at'=> new \dateTime],
            ['fabrictype_id' => 8, 'fabrictype_name' => 'woolen', 'created_at'=> new \dateTime],
            ['fabrictype_id' => 9, 'fabrictype_name' => 'poplin', 'created_at'=> new \dateTime],
            ['fabrictype_id' => 10, 'fabrictype_name' => 'dobby', 'created_at'=> new \dateTime],
            ['fabrictype_id' => 11, 'fabrictype_name' => 'knitting', 'created_at'=> new \dateTime],
            ['fabrictype_id' => 12, 'fabrictype_name' => 'tulle', 'created_at'=> new \dateTime],
            ['fabrictype_id' => 13, 'fabrictype_name' => 'organza', 'created_at'=> new \dateTime],
            ['fabrictype_id' => 14, 'fabrictype_name' => 'lace', 'created_at'=> new \dateTime],
            ['fabrictype_id' => 15, 'fabrictype_name' => 'corduroy', 'created_at'=> new \dateTime],
            ['fabrictype_id' => 16, 'fabrictype_name' => 'terry', 'created_at'=> new \dateTime]
        ]);

        DB::table('product_decoration_attribute')->insert([
            ['decoration_id' => 1, 'decoration_name' => 'ruffles', 'created_at'=> new \dateTime],
            ['decoration_id' => 2, 'decoration_name' => 'embroidary', 'created_at'=> new \dateTime],
            ['decoration_id' => 3, 'decoration_name' => 'bow', 'created_at'=> new \dateTime],
            ['decoration_id' => 4, 'decoration_name' => 'lace', 'created_at'=> new \dateTime],
            ['decoration_id' => 5, 'decoration_name' => 'beading', 'created_at'=> new \dateTime],
            ['decoration_id' => 6, 'decoration_name' => 'sashes', 'created_at'=> new \dateTime],
            ['decoration_id' => 7, 'decoration_name' => 'hollowout', 'created_at'=> new \dateTime],
            ['decoration_id' => 8, 'decoration_name' => 'pockets', 'created_at'=> new \dateTime],
            ['decoration_id' => 9, 'decoration_name' => 'sequined', 'created_at'=> new \dateTime],
            ['decoration_id' => 10, 'decoration_name' => 'applique', 'created_at'=> new \dateTime],
            ['decoration_id' => 11, 'decoration_name' => 'button', 'created_at'=> new \dateTime],
            ['decoration_id' => 12, 'decoration_name' => 'tiered', 'created_at'=> new \dateTime],
            ['decoration_id' => 13, 'decoration_name' => 'rivet', 'created_at'=> new \dateTime],
            ['decoration_id' => 14, 'decoration_name' => 'feathers', 'created_at'=> new \dateTime],
            ['decoration_id' => 15, 'decoration_name' => 'flowers', 'created_at'=> new \dateTime],
            ['decoration_id' => 16, 'decoration_name' => 'pearls', 'created_at'=> new \dateTime],
            ['decoration_id' => 17, 'decoration_name' => 'pleat', 'created_at'=> new \dateTime],
            ['decoration_id' => 18, 'decoration_name' => 'crystal', 'created_at'=> new \dateTime],
            ['decoration_id' => 19, 'decoration_name' => 'ruched', 'created_at'=> new \dateTime],
            ['decoration_id' => 20, 'decoration_name' => 'draped', 'created_at'=> new \dateTime],
            ['decoration_id' => 21, 'decoration_name' => 'tassel', 'created_at'=> new \dateTime],
            ['decoration_id' => 22, 'decoration_name' => 'plain', 'created_at'=> new \dateTime],
            ['decoration_id' => 23, 'decoration_name' => 'cascading', 'created_at'=> new \dateTime]
        ]);

        DB::table('product_patterntype_attribute')->insert([
            ['patterntype_id' => 1, 'patterntype_name' => 'animal', 'created_at'=> new \dateTime],
            ['patterntype_id' => 2, 'patterntype_name' => 'print', 'created_at'=> new \dateTime],
            ['patterntype_id' => 3, 'patterntype_name' => 'dot', 'created_at'=> new \dateTime],
            ['patterntype_id' => 4, 'patterntype_name' => 'solid', 'created_at'=> new \dateTime],
            ['patterntype_id' => 5, 'patterntype_name' => 'patchwork', 'created_at'=> new \dateTime],
            ['patterntype_id' => 6, 'patterntype_name' => 'striped', 'created_at'=> new \dateTime],
            ['patterntype_id' => 7, 'patterntype_name' => 'geometric', 'created_at'=> new \dateTime],
            ['patterntype_id' => 8, 'patterntype_name' => 'plaid', 'created_at'=> new \dateTime],
            ['patterntype_id' => 9, 'patterntype_name' => 'leopard', 'created_at'=> new \dateTime],
            ['patterntype_id' => 10, 'patterntype_name' => 'floral', 'created_at'=> new \dateTime],
            ['patterntype_id' => 11, 'patterntype_name' => 'character', 'created_at'=> new \dateTime],
            ['patterntype_id' => 12, 'patterntype_name' => 'splice', 'created_at'=> new \dateTime],
        ]);
    }
}
