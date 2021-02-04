<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class City extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'm_city';

    protected $fillable = [
        'id',
        'name',
        'province_id',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    public function province()
    {
        return $this->belongsTo('App\Model\Tables\Province', 'province_id', 'id');
    }

}
