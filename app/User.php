<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten', 'email', 'password', 'avatar', 'cover', 'diaChi', 'sdt', 'gioithieu', 'sodkkd', 'cmnd', 'mst', 'locations_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'avatar_path',
        'cover_path',
    ];

    public function getCoverPathAttribute(){
        if (empty($this->attributes['cover'])) {
            return \URL::to("/").'\\storage\\img\\no-img.png';
        }
        else {
            
            return \URL::to("/").'\\storage\\img\\userfiles\\'.md5($this->attributes['id']).'\\images\\Cover\\' . $this->attributes['cover'];
        }
    }

    public function getAvatarPathAttribute()
    {
        if (empty($this->attributes['avatar'])) {
            return \URL::to("/").'\\storage\\img\\no-avatar.png';
        }
        else {
            return \URL::to("/").'\\storage\\img\\userfiles\\'.md5($this->attributes['id']).'\\images\\Avatar\\' . $this->attributes['avatar'];
        }
    }

    public function contacts(){
        return $this->hasMany(Contact::class, 'users_id');
    }
    public function cars(){
        return $this->belongsTo(Car::class, 'users_id');
    }
}
