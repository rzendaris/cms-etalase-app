<?php

namespace App\Model\Views;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class PopulationPerCity extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'population_per_city';

    protected $fillable = [
        'population',
        'name',
        'city_id',
    ];
}
