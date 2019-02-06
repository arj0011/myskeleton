<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', ['as' => '/', 'uses' =>'Web\AuthController@showLogin']);

Route::prefix('admin')->group(function(){
	Route::get('/','Web\AuthController@showLogin');
	Route::get('/register','Web\AuthController@showRegister');
	Route::post('/signin','Web\AuthController@login');
	Route::post('/signup','Web\AuthController@register');
  	

  Route::group(['middleware' => 'require.admin'], function () {
      Route::get('/dashboard','Web\DashboardController@index')->name('dashboard');
      Route::get('/profile','Web\DashboardController@profile')->name('profile');
    	Route::post('/update-profile/{user_id}','Web\DashboardController@updateProfile')->name('update-profile');
    	Route::get('/signout','Web\AuthController@logout');
    	
      //users
      Route::get('/create-user','Web\UserController@createUser')->name('create-user');
      Route::post('/store-user','Web\UserController@storeUser')->name('store-user');
      Route::get('/users','Web\UserController@index');
    	Route::get('/editUser/{user_id}','Web\UserController@showEditUser');
      Route::post('/updateUser','Web\UserController@updateUser');
      Route::post('/deleteUser','Web\UserController@removeUser');
    	Route::post('/viewUser','Web\UserController@viewUser');
      Route::get('users-export','Web\UserController@exportUserData')->name('users-export');
      Route::post('users-import','Web\UserController@importUserData')->name('users-import');
      Route::get('users-format','Web\UserController@downloadFormat')->name('users-format');
      Route::post('remove-all-users','Web\UserController@deleteAllUser')->name('deleteAllUser');

      //Teachers
      Route::get('/create-teacher','Web\TeacherController@createTeacher')->name('create-teacher');
      Route::post('/store-teacher','Web\TeacherController@storeTeacher')->name('store-teacher');
      Route::get('/teachers','Web\TeacherController@index');
      Route::get('/editTeacher/{user_id}','Web\TeacherController@showEditTeacher');
      Route::post('/updateTeacher','Web\TeacherController@updateTeacher');
      Route::post('/deleteTeacher','Web\TeacherController@removeTeacher');
      Route::post('/viewTeacher','Web\TeacherController@viewTeacher');
      Route::get('teachers-export','Web\TeacherController@exportTeacherData')->name('teachers-export');
      Route::post('teachers-import','Web\TeacherController@importTeacherData')->name('teachers-import');
      Route::get('teachers-format','Web\TeacherController@downloadFormat')->name('teachers-format');
      Route::post('remove-all-teachers','Web\TeacherController@deleteAllTeacher')->name('deleteAllTeacher');

      //Post
      Route::resource('posts', 'Web\PostController');


    //Authorization
    Route::group(['middleware' => 'authorize'], function () {
        //Roles
        Route::get('role-list','Web\RoleController@index')->name('role-list');
        Route::get('create-role','Web\RoleController@create')->name('create-role');
        Route::post('store-role','Web\RoleController@store')->name('store-role');
        Route::get('edit-role/{id}','Web\RoleController@edit')->name('edit-role');
        Route::put('update-role/{id}','Web\RoleController@update')->name('update-role');
        Route::post('destroy-role','Web\RoleController@destroy')->name('destroy-role');  
        //Permission      
        Route::get('permission-list','Web\PermissionController@index')->name('permission-list');
        Route::get('create-permission','Web\PermissionController@create')->name('create-permission');
        Route::post('store-permission','Web\PermissionController@store')->name('store-permission');
        Route::get('edit-permission/{id}','Web\PermissionController@edit')->name('edit-permission');
        Route::put('update-permission/{id}','Web\PermissionController@update')->name('update-permission');
        Route::post('destroy-permission','Web\PermissionController@destroy')->name('destroy-permission');
    });  

	});
});
