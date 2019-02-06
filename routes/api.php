<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' =>'auth'],function(){
	
	//Calling URL
	//http://localhost/myskeleton/api/auth/login

  	Route::post('signup', 'API\AuthController@register');
	Route::post('login', 'API\AuthController@login');

	Route::get('getAuthUser', 'API\AuthController@getAuthUser');
	Route::get('logout', 'API\AuthController@logout');
	
});



Route::middleware(['api', 'jwt'])->group(function($request){
  	Route::get('validateVersion/{appVersion}','API\AuthController@validateVersion');
 	Route::group(['prefix'=>'video'],function(){
    	Route::get('publicVideos','API\VideoController@getPublicVideos');
 	});

 	Route::apiResource('users','API\UserController');
 	Route::apiResource('posts','API\PostController');
  
});
