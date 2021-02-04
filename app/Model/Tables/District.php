<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class District extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'm_district';

    protected $fillable = [
        'id',
        'name',
        'city_id',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    public function city()
    {
        return $this->belongsTo('App\Model\Tables\City', 'city_id', 'id');
    }

}
