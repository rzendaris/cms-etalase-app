<?php

namespace App\Model\Table;

use Illuminate\Database\Eloquent\Model;

class MstAds extends Model
{
  use \Awobaz\Compoships\Compoships;

  protected $table = 'mst_ads';

  protected $fillable = [
      'id', 'picture', 'name', 'link', 'orders', 'created_at', 'created_by', 'status', 'updated_by', 'updated_at'
  ];
}
