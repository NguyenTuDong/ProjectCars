<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    public $timestamps = false;
    
    public function cars(){
        return $this->hasMany(Car::class, 'fuels_id');
    }
}
