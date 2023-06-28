<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $table = 'rewards';

    public function trx()
    {
        return $this->hasMany('App\TrxReedem', 'reward_id');
    }
}
