<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_Transaction_Payment extends Model
{
    protected $table = 'sales_transaction_payment';
    protected $fillable = [
        'transaction_id',
        'company_bank_id',
        'amount',
        'sender_bank',
        'sender_account_number',
        'sender_name',
        'note',
        'status',
        'receive_amount',
        'reject_comment'
    ];
    protected $primaryKey = 'transaction_id';
}
