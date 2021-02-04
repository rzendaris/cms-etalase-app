<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class Marital extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'm_marital';

    protected $fillable = [
        'id',
        'name'
    ];

}
