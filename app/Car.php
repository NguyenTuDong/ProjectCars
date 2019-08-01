<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Car extends Model
{
    protected $appends = [
        'hinhanh_path',
    ];

    public function gethinhanhPathAttribute(){
        if (empty($this->attributes['hinhanh'])) {
            return Storage::url('img/no-img.png');
        }
        else {
            return Storage::url('img/userfiles/'.md5($this->attributes['users_id']).'/images/'.$this->attributes['hinhanh']);
        }
    }


    public function types(){
        return $this->belongsTo(Type::class, 'types_id');
    }
    public function colors(){
        return $this->belongsTo(Color::class, 'colors_id');
    }
    public function furnitures(){
        return $this->belongsTo(Color::class, 'furnitures_id');
    }
    public function conditions(){
        return $this->belongsTo(Condition::class, 'conditions_id');
    }
    public function origins(){
        return $this->belongsTo(Origin::class, 'origins_id');
    }
    public function transmissions(){
        return $this->belongsTo(Transmission::class, 'transmissions_id');
    }
    public function fuels(){
        return $this->belongsTo(Fuel::class, 'fuels_id');
    }
    public function styles(){
        return $this->belongsTo(Style::class, 'styles_id');
    }
    public function users(){
        return $this->belongsTo(User::class, 'users_id');
    }
    public function locations(){
        return $this->belongsTo(Location::class, 'locations_id');
    }
    
    
    public function convenientcars(){
        return $this->hasMany(Convenientcar::class, 'cars_id', 'id');
    }
}
