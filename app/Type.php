<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function brands(){
        return $this->belongsTo(Brand::class, 'brands_id');
    }
    public function cars(){
        return $this->hasMany(Car::class, 'types_id');
    }
}
