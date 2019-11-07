<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function orderItem(){
        return $this->hasMany('App\orderitem');
    }
}
