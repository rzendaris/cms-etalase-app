<?php

namespace App\Model\Table;

use Illuminate\Database\Eloquent\Model;

class Apps extends Model
{
  use \Awobaz\Compoships\Compoships;

  protected $table = 'apps';

  protected $fillable = [
      'id', 'name', 'type', 'app_icon', 'eu_sdk_version', 'category_id', 'rate', 'version', 'file_size', 'description', 'updates_description',
      'link', 'apk_file', 'expansion_file','media', 'developer_id', 'is_approve','reject_reason', 'is_active', 'is_partnership', 'created_at', 'created_by', 'updated_at', 'updated_by'
  ];
  public function categories()
  {
      return $this->belongsTo('App\Model\Table\MstCategories', 'category_id', 'id');
  }
  public function ratings()
  {
      return $this->hasMany('App\Model\Table\Ratings', 'apps_id', 'id');
  }
}
