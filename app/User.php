<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'email_verified_at', 'password', 'picture', 'role_id', 'token', 'dev_web', 'dev_country_id', 'dev_address', 'eu_birthday','eu_imei1','eu_imei2','eu_device_brand','eu_device_model','eu_sdk_version', 'eu_device_id', 'is_verified', 'is_blocked', 'created_by', 'updated_by', 'remember_token', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function countrys()
    {
        return $this->belongsTo('App\Model\Table\MstCountry', 'dev_country_id', 'id');
    }
}
