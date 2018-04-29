<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'master_province';
    protected $fillable = [
        'province_id','province_name'
    ];
}
