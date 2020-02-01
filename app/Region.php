<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public $timestamps = false;
    
    public function locations(){
        return $this->hasMany(Location::class, 'regions_id');
    }
}
