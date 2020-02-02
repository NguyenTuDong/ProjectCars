<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public $timestamps = false;
    
    protected $appends = [
        'rgb_path',
    ];

    public function getRgbPathAttribute(){
        return \URL::to("/")."\\storage\\img\\color\\".$this->attributes['rgb'];
    }

    public function cars(){
        return $this->hasMany(Car::class, 'colors_id');
    }

    public function furniturecars(){
        return $this->hasMany(Car::class, 'furnitureColor_id');
    }
}
