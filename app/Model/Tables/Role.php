<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class Role extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'role';

    protected $fillable = [
        'id',
        'name'
    ];

}
