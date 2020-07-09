<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class MemberStatus extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'm_member_status';

    protected $fillable = [
        'id',
        'name'
    ];

}
