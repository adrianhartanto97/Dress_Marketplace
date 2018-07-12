<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RFQ_Request extends Model
{
    protected $table = 'rfq_request';
    protected $fillable = [
        'rfq_request_id',
        'user_id',
        'item_name',
        'description',
        'qty',
        'request_expired',
        'budget_unit_min',
        'budget_unit_max',
        'status',
        'accept_rfq_offer_id'
    ];
    protected $primaryKey = 'rfq_request_id';
}
