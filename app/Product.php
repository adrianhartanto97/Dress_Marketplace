<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = [
        'product_id',
        'store_id',
        'name',
        'min_order',
        'weight',
        'description',
        'photo',
        'style_id',
        'season_id',
        'neckline_id',
        'sleevelength_id',
        'waiseline_id',
        'material_id',
        'fabrictype_id',
        'decoration_id',
        'patterntype_id',
        'product_type',
        'product_active_status',
        'product_ownership'
    ];
    protected $primaryKey = 'product_id';
}
