<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convenientcar extends Model
{
    public $timestamps = false;
    
    public function cars(){
        return $this->belongsTo(Car::class, 'cars_id');
    }
    public function convenients(){
        return $this->belongsTo(Convenient::class, 'convenients_id');
    }
}
