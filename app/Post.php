<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function category(){
        return $this->belongsTo('App\Categories');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
