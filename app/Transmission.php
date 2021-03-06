<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transmission extends Model
{
    public $timestamps = false;
    
    public function cars(){
        return $this->hasMany(Car::class, 'transmissions_id');
    }
}
