<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class Family extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'family';

    protected $fillable = [
        'id',
        'family_no',
        'inherit_no',
        'address',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'post_code',
        'photo',
        'tlp_no',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    public function family_member()
    {
        return $this->hasMany('App\Model\Tables\FamilyMember', 'family_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo('App\Model\Tables\Province', 'province_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo('App\Model\Tables\City', 'city_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo('App\Model\Tables\District', 'district_id', 'id');
    }

    public function village()
    {
        return $this->belongsTo('App\Model\Tables\Village', 'village_id', 'id');
    }

}
