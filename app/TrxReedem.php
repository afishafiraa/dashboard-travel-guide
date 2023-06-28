<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrxReedem extends Model
{
  protected $table = 'trx_reedem';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_id', 'reward_id', 'created_at',
  ];

  public function reward()
  {
      return $this->belongsTo('App\Reward');
  }

  public function user()
  {
      return $this->belongsTo('App\User');
  }
}
