<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $table = 'master_courier';
    protected $fillable = [
        'courier_id','courier_name','alias_name'
    ];
}
