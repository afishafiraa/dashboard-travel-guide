<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryTourism extends Model
{
    protected $table = 'tourism_gallery';
    
    public function tourism()
    {
        return $this->belongsTo('App\Tourism','tourism_id');
    }
}
