<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class Member extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'member';

    protected $fillable = [
        'id',
        'full_name',
        'sur_name',
        'nik',
        'birthday',
        'religion_id',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'education_id',
        'job_id',
        'marital_id',
        'ethnic_id',
        'title_adat_id',
        'nationality_status',
        'school_name',
        'graduation_year',
        'member_status_id',
        'instance_name',
        'is_life',
        'gender_status',
        'address',
        'phone_number',
        'photo',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];


    public function member_status()
    {
        return $this->belongsTo('App\Model\Tables\MemberStatus', 'member_status_id', 'id');
    }

    public function ethnic()
    {
        return $this->belongsTo('App\Model\Tables\Ethnic', 'ethnic_id', 'id');
    }

    public function job()
    {
        return $this->belongsTo('App\Model\Tables\Job', 'job_id', 'id');
    }

    public function education()
    {
        return $this->belongsTo('App\Model\Tables\Education', 'education_id', 'id');
    }

    public function title_adat()
    {
        return $this->belongsTo('App\Model\Tables\TitleAdat', 'title_adat_id', 'id');
    }

    public function marital()
    {
        return $this->belongsTo('App\Model\Tables\Marital', 'marital_id', 'id');
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

    public function religion()
    {
        return $this->belongsTo('App\Model\Tables\Religion', 'religion_id', 'id');
    }

    public function family_member()
    {
        return $this->belongsTo('App\Model\Tables\FamilyMember', 'id', 'member_id');
    }

}
