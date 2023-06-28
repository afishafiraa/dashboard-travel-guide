<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';

    public function tourism()
    {
        return $this->hasMany('App\Tourism');
    }
}
