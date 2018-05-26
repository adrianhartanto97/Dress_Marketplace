<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Price extends Model
{
    protected $table = 'product_price';
    protected $fillable = [
        'product_id',
        'qty_min',
        'qty_max',
        'price'
    ];
    protected $primaryKey = ['product_id', 'qty_min', 'qty_max'];
    public $incrementing = false;
}
