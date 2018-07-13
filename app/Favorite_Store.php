<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite_Store extends Model
{
    protected $table = 'favorite_store';
    protected $fillable = [
            'user_id',
            'store_id'
    ];
}
