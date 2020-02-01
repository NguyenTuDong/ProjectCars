<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convenient extends Model
{
    public $timestamps = false;
    
    public function convenientcar(){
        return $this->hasMany(Convenientcar::class, 'convenients_id');
    }
}
