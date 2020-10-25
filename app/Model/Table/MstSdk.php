<?php

namespace App\Model\Table;

use Illuminate\Database\Eloquent\Model;

class MstSdk extends Model
{
  use \Awobaz\Compoships\Compoships;

  protected $table = 'mst_sdk';

  protected $fillable = [
      'id',
      'sdk'
  ];
}
