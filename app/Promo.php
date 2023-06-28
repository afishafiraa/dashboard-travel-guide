<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{

  public function qrcode()
  {
      return $this->hasMany('App\Qr', 'promo_id');
  }

  public function item()
  {
      return $this->belongsTo('App\MerchantItem', 'item_id');
  }
}
