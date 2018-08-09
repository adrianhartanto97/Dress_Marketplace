<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Report extends Model
{
    protected $table = 'product_report';
    protected $fillable = [
            'report_id',
            'product_id',
            'user_id',
            'issue',
            'comment'
    ];
}
