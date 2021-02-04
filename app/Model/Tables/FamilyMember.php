<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author RafiZendaris
 */
class FamilyMember extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'family_member';

    protected $fillable = [
        'id',
        'family_id',
        'member_id'
    ];

    public function member()
    {
        return $this->hasMany('App\Model\Tables\Member', 'id', 'member_id');
    }

    public function member_belongs()
    {
        return $this->belongsTo('App\Model\Tables\Member', 'member_id', 'id');
    }

    public function family()
    {
        return $this->belongsTo('App\Model\Tables\Family', 'family_id', 'id');
    }

}
