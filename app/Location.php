<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;
    
    public function regions(){
        return $this->belongsTo(Region::class, 'regions_id');
    }
    public function users(){
        return $this->hasMany(User::class, 'locations_id');
    }
}
