<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    protected $appends = [
        'hinhanh_path',
    ];

    public function getHinhanhPathAttribute(){
        return public_path()."\\img\\logo\\".$this->attributes['hinhanh'];
    }

    public function cars(){
        return $this->hasMany(Car::class, 'styles_id');
    }
}
