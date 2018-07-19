<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Param_Settings extends Model
{
    protected $table = 'param_settings';
    protected $fillable = [
        'random_seed',
        'param_firefly',
        'param_maks_epoch_ffa',
        'param_base_beta',
        'param_gamma',
        'param_alpha',
        'param_maks_epoch_psnn',
        'param_summing_units',
        'param_learning_rate',
        'param_momentum',
        'rmse',
        'status_use'
    ];
    protected $primaryKey = 'id';
}
