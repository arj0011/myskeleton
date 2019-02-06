<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class AuthController extends Controller
{
    public function showRegister()
    {
    	//Get all roles and pass it to the view
        $roles = Role::get();
        return view('backend.register',['roles'=>$roles]);
    }

    public function register(Request $request)
    {
    	$input = $request->all();
    	$validate = Validator::make($input,[
    		'name'=>'required|string|max:255',
    		'email'=>'required|string|email|max:255|unique:users',
    		'password'=>'required|confirmed|max:6'
    	]);
    	if($validate->fails()){
    		return back()->withErrors($validate);
    	}else{
    		$user = new User;
    		$user->name = $request->name;
    		$user->email = $request->email;
    		$user->password = bcrypt($request->password);
    		if($user->save()){
                $roles = $request->roles;
                //Checking if a role was selected
                if (isset($roles)) {
                    foreach ($roles as $role) {
                    $role_r = Role::where('id', '=', $role)->firstOrFail();            
                    $user->assignRole($role_r); //Assigning role to user
                    $user->role = $role;
                    $user->save(); 
                    }
                }        
    			return back()->with('success','Register successfully');
    		}else{
    			return back()->with('failed','Failed to register');
    		}
    	}
    }

    public function showLogin()
    {
    	return view('backend.login');
    }

    public function login(Request $request)
    {
    	$input = $request->all('email','password');
    	$validate = Validator::make($input,[
    		'email'=>'required|email|max:255',
    		'password'=>'required|max:6'
    	]);
    	if($validate->fails()){
    		return back()->withErrors($validate);
    	}else{
    		$credentials = array('email'=>$input['email'],'password'=>$input['password']);
    		if(!$token = Auth::guard('web')->attempt($credentials)){
    			return back()->with('failed','Invalide Credentials');
    		}else{
    			return redirect('admin/dashboard');
    		}
    	}
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Session::flush();
        return redirect('/');
    }

}
