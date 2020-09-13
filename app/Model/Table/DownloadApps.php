<?php

namespace App\Model\Table;

use Illuminate\Database\Eloquent\Model;

class DownloadApps extends Model
{
  use \Awobaz\Compoships\Compoships;

  protected $table = 'download_apps';

  protected $fillable = [
      'id', 'apps_id', 'end_users_id', 'clicked', 'installed', 'version'
  ];
  protected $hidden = [
      'created_at', 'updated_at', 'clicked_at',
  ];
  public function endusers()
  {
      return $this->belongsTo('App\User', 'end_users_id', 'id');
  }
  public function apps()
  {
      return $this->belongsTo('App\Model\Table\Apps', 'apps_id', 'id');
  }
}
