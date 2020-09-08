<?php

namespace App\Model\Table;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
  use \Awobaz\Compoships\Compoships;

  protected $table = 'notifikasi';

  protected $fillable = [
      'id', 'to_users_id','from_users_id',  'content','apps_id','read_at','created_at','updated_at'
  ];
  public function tousers()
  {
      return $this->belongsTo('App\User', 'to_users_id', 'id');
  }
  public function fromusers()
  {
      return $this->belongsTo('App\User', 'from_users_id', 'id');
  }
  public function apps()
  {
      return $this->belongsTo('App\Model\Table\Apps', 'apps_id', 'id');
  }
}
