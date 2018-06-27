<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store_Rating extends Model
{
    protected $table = 'sales_transaction_store_rating';
    protected $fillable = [
            'transaction_id',
            'store_id',
            'rating',
            'status'
    ];
}
