<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $table = 'withdraw';
    protected $fillable = [
        'user_id',
        'amount',
        'bank_name',
        'branch',
        'account_number',
        'name_in_account'
    ];
}
