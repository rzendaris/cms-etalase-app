<?php

namespace App\Model\Table;

use Illuminate\Database\Eloquent\Model;

class MstCountry extends Model
{
  use \Awobaz\Compoships\Compoships;

  protected $table = 'mst_countries';

  protected $fillable = [
      'id',
      'country'
  ];
}
