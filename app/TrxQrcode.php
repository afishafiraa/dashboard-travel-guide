<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrxQrcode extends Model
{
  protected $table = 'trx_qrcode';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'qrcode_id', 'trx_time',
  ];

  public function qrcode()
  {
      return $this->belongsTo('App\Qr', 'qrcode_id');
  }
}
