<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{

  public function user()
  {
      return $this->hasOne('App\User');
  }

  public function item()
  {
      return $this->hasMany('App\MerchantItem', 'merchant_id');
  }

  public function category()
  {
      return $this->belongsTo('App\MerchantCategory', 'category_id');
  }
}
