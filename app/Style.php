<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    public $timestamps = false;
    
    protected $appends = [
        'hinhanh_path',
    ];

    public function getHinhanhPathAttribute(){
        return \URL::to("/")."\\storage\\img\\style\\".$this->attributes['hinhanh'];
    }

    public function cars(){
        return $this->hasMany(Car::class, 'styles_id');
    }
}
