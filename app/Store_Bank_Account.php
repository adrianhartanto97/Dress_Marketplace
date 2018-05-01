<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store_Bank_Account extends Model
{
    protected $table = 'store_bank_account';
    protected $fillable = [
            'store_id',
            'bank_name',
            'branch',
            'bank_account_number',
            'name_in_bank'
    ];
}
