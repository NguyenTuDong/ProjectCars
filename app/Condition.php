<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    public $timestamps = false;
    
    public function cars(){
        return $this->hasMany(Car::class, 'conditions_id');
    }
}
