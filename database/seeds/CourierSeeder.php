<?php

use Illuminate\Database\Seeder;
use App\Courier;

class CourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_courier')->delete();
        $json = File::get("database/data/master_courier.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Courier::create(array(
                'courier_id' => $obj->courier_id,
                'courier_name' => $obj->courier_name,
                'alias_name' => $obj->alias_name
            ));
        }
    }
}
