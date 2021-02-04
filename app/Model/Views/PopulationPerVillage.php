<?php

namespace App\Model\Views;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class PopulationPerVillage extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'population_per_village';

    protected $fillable = [
        'population',
        'name',
        'village_id',
    ];
}
