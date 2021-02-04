<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class Religion extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'm_religion';

    protected $fillable = [
        'id',
        'name'
    ];

}
