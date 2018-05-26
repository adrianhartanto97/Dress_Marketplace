<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Size extends Model
{
    protected $table = 'product_size';
    protected $fillable = [
        'product_id',
        'size_id',
        'recommendation'
    ];
    protected $primaryKey = ['product_id', 'size_id'];
    public $incrementing = false;
}
