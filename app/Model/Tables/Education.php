<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class Education extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'm_education';

    protected $fillable = [
        'id',
        'name'
    ];

}
