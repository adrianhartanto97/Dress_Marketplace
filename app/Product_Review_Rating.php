<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Review_Rating extends Model
{
    protected $table = 'sales_transaction_product_review_rating';
    protected $fillable = [
            'transaction_id',
            'product_id',
            'rating',
            'review',
            'status'
    ];
}
