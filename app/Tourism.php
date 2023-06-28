<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tourism extends Model
{
    protected $table = 'tourism';

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function gallery()
    {
        return $this->hasMany('App\GalleryTourism','tourism_id');
    }
}
