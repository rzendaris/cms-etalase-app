<?php

namespace App\Model\Views;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class PopulationPerDistrict extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'population_per_district';

    protected $fillable = [
        'population',
        'name',
        'district_id',
    ];
}
