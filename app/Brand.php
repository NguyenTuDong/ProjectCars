<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $appends = [
        'logo_path',
    ];

    public function getLogoPathAttribute(){
        return \URL::to("/")."\\storage\\img\\logo\\".$this->attributes['logo'];
    }

    public function types(){
        return $this->hasMany(Type::class, 'brands_id', 'id');
    }
}
