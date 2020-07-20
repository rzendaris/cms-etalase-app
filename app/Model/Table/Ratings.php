<?php

namespace App\Model\Table;

use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
  use \Awobaz\Compoships\Compoships;

  protected $table = 'ratings';

  protected $fillable = [
      'id', 'apps_id', 'end_users_id', 'ratings', 'comment', 'users_dev_id', 'reply', 'comment_at', 'reply_at', 'read_at'
  ];
  public function endusers()
  {
      return $this->belongsTo('App\User', 'end_users_id', 'id');
  }
  public function usersdev()
  {
      return $this->belongsTo('App\User', 'users_dev_id', 'id');
  }
  public function apps()
  {
      return $this->belongsTo('App\Model\Table\Apps', 'apps_id', 'id');
  }
}
