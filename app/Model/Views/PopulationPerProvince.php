<?php

namespace App\Model\Views;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class PopulationPerProvince extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'population_per_province';

    protected $fillable = [
        'population',
        'name',
        'province_id',
    ];
}
