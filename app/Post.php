<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
	protected $postFolder = '/public/uploads/posts/';
    public function getBannerImageAttribute($value='')
    {
    	if($value != Null){
    		return url('/').$this->postFolder.$value;
    	}else{
    		return url('/').'/public/dist/img/img-placeholder.gif';
    	}
    }
    // public function getUserIdAttribute($value='')
    // {
    // 	$user = User::select('name')->where('id', $value)->first();
    // 	return $user->name;
    // }

    public function User()
    {    
        return $this->belongsTo('App\User','user_id')->select('id','name','image');
    }

    public function Comment()
    {
        return $this->hasMany('App\Comment');
    }
}
