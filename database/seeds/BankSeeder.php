<?php

use Illuminate\Database\Seeder;
use App\Company_Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_bank_account')->delete();
        $json = File::get("database/data/master_bank.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Company_Bank::create(array(
                'bank_id' => $obj->bank_id, 
                'bank_name' => $obj->bank_name,
                'branch' => $obj->branch ,
                'account_number' => $obj->account_number,
                'name_in_account' => $obj->name_in_account,
                'logo' => $obj->logo
            ));
        }
    }
}
