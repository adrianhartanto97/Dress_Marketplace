<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store_Courier_Service extends Model
{
    protected $table = 'store_courier_service';
    protected $fillable = [
            'store_id',
            'courier_id'
    ];
}
