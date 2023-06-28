<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantItem extends Model
{
  protected $table = 'merchant_items';

  public function promo()
  {
      return $this->hasMany('App\Promo', 'item_id');
  }

  public function merchant()
  {
      return $this->belongsTo('App\Merchant');
  }
}
