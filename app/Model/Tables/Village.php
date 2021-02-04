<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class Village extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'm_village';

    protected $fillable = [
        'id',
        'name',
        'district_id',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    public function district()
    {
        return $this->belongsTo('App\Model\Tables\District', 'district_id', 'id');
    }

}
