<?php

use Illuminate\Database\Seeder;
use App\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_province')->delete();
        $json = File::get("database/data/master_province.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Province::create(array(
                'province_id' => $obj->province_id,
                'province_name' => $obj->province
            ));
        }
    }
}
