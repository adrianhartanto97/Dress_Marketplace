<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store_Supporting_Document extends Model
{
    protected $table = 'store_supporting_documents';
    protected $fillable = [
            'ktp',
            'siup',
            'npwp',
            'skdp',
            'tdp',
    ];
    protected $primaryKey = 'store_id';
}
