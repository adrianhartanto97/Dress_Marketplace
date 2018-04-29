<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'master_city';
    protected $fillable = [
        'city_id', 'province_id','city_name', 'city_type', 'postal_code'
    ];
}
