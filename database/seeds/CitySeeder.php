<?php

use Illuminate\Database\Seeder;
use App\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_city')->delete();
        $json = File::get("database/data/master_city.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            City::create(array(
                'city_id' => $obj->city_id, 
                'province_id' => $obj->province_id,
                'city_name' => $obj->city_name, 
                'city_type' => $obj->type, 
                'postal_code' => $obj->postal_code
            ));
        }
    }
}
