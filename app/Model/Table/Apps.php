<?php

namespace App\Model\Table;

use Illuminate\Database\Eloquent\Model;

class Apps extends Model
{
  use \Awobaz\Compoships\Compoships;

  protected $table = 'apps';

  protected $fillable = [
      'id', 'name', 'type', 'app_icon', 'sdk_target_id', 'category_id', 'rate', 'version', 'file_size', 'description', 'updates_description',
      'link', 'apk_file', 'expansion_file', 'developer_id', 'is_approve', 'is_active', 'is_partnership', 'created_at', 'created_by', 'updated_at', 'updated_by'
  ];
  public function skds()
  {
      return $this->belongsTo('App\Model\Table\MstSdk', 'sdk_target_id', 'id');
  }
  public function categories()
  {
      return $this->belongsTo('App\Model\Table\MstCategory', 'category_id', 'id');
  }
  public function developers()
  {
      return $this->belongsTo('App\User', 'developer_id', 'id');
  }
}
