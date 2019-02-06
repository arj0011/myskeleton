<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	public function Post()
    {
    	return $this->belongsTo('App\Post');
    }    

    public function User()
    {
    	return $this->belongsTo('App\User');
    } 
}
