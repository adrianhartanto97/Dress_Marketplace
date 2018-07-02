<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partnership_Request extends Model
{
    protected $table = 'partnership_request';
    protected $fillable = [
        'partnership_id',
        'product_id',
        'product_id_partner',
        'min_order',
        'status',
        'created_at',
        'updated_at'
    ];
}
