<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partnership_Request_Price extends Model
{
    protected $table = 'partnership_request_price';
    protected $fillable = [
        'product_id_partner',
        'qty_min',
        'qty_max',
        'price',
        'created_at',
        'updated_at'
    ];
}
