<?php

use Illuminate\Database\Seeder;
use App\SortBy;

class SortBySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_sort')->delete();
        $json = File::get("database/data/master_sort.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            SortBy::create(array(
                'sort_id' => $obj->sort_id,
                'sort_name' => $obj->sort_name,
                'alias_name' => $obj->alias_name

            ));
        }
    }
}
