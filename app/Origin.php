<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    public $timestamps = false;
    
    public function cars(){
        return $this->hasMany(Car::class, 'origins_id');
    }
}
