<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function users(){
        return $this->belongsTo(User::class, 'users_id');
    }
}
