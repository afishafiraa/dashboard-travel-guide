<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qr extends Model
{
  protected $table = 'qrcode';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_id', 'promo_id', 'expiry_time',
  ];

  public function trx()
  {
      return $this->hasMany('App\TrxQrcode', 'qrcode_id');
  }

  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function promo()
  {
      return $this->belongsTo('App\Promo');
  }
}
