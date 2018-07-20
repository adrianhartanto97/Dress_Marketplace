<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CitySeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(CourierSeeder::class);
        $this->call(DressAttributeSeeder::class);
        $this->call(SortBySeeder::class);

    }
}
