<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RFQ_Offer extends Model
{
    protected $table = 'rfq_offer';
    protected $fillable = [
        'rfq_offer_id',
        'rfq_request_id',
        'store_id',
        'description',
        'price_unit',
        'weight_unit'
    ];
    protected $primaryKey = 'rfq_offer_id';
}
