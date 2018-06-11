<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company_Bank extends Model
{
    protected $table = 'company_bank_account';
    protected $fillable = [
        'bank_id',
        'bank_name',
        'branch',
        'account_number',
        'name_in_account',
        'logo'
    ];
    protected $primaryKey = 'bank_id';
}
