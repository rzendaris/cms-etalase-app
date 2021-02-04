<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class Job extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'm_job';

    protected $fillable = [
        'id',
        'name',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

}
