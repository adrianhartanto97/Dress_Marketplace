<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SortBy extends Model
{
	protected $table = 'master_sort';
    protected $fillable = [
        'sort_id','sort_name','alias_name'
    ];
    //
}
