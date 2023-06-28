<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantCategory extends Model
{
  protected $table = 'category_merchant';

  public function promo()
  {
      return $this->hasMany('App\Merchant', 'category_id');
  }
}
