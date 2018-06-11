<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_Transaction_Header extends Model
{
    protected $table = 'sales_transaction_header';
    protected $fillable = [
        'transaction_id',
        'user_id',
        'receiver_name',
        'address',
        'province',
        'city',
        'phone_number',
        'postal_code',
        'use_point',
    ];
    protected $primaryKey = 'transaction_id';
}
