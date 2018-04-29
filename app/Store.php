<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'store';
    protected $fillable = [
            'store_id',
            'user_id',
            'name',
            'photo',
            'banner',
            'description',
            'established_year',
            'province',
            'city',
            'business_type',
            'contact_person_name',
            'contact_person_job_title',
            'contact_person_phone_number',
            'store_active_status',
            'reject_comment'
    ];
}
