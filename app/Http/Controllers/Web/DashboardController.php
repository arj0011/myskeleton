<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;
use App\Post;

class DashboardController extends Controller
{
	protected $profileFolder = 'public/uploads/users/';
    public function index()
    {
    	$user = User::find(Auth::id());
        $role = Auth::user()->getRoleNames()[0];
        $posts = Post::with('User')->get();
        return view('backend.dashboard.home',compact('user','role','posts'));
    }

    public function profile()
    {
    	$user = User::find(Auth::id());
    	$role = Auth::user()->getRoleNames()[0];
    	return view('backend.dashboard.profile',compact('user','role'));
    }

    public function updateProfile(Request $request,$id)
    {
    	$input = $request->all();
    	$validate = Validator::make($input,[
	        'name' => 'required|string|max:255',
	        'first_name' => 'string|max:30',
	        'last_name' => 'string|max:30',
	        'email' => 'required|max:255|unique:users,email,'.decrypt($id),
	        'mobile' => 'required|max:10|unique:users,mobile,'.decrypt($id),
	        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    	]);
    	if($validate->fails()){
    		return back()->withErrors($validate);
    	}else{
    		$user = User::find(decrypt($id));
    		if($user){
            	$fileName = '';
            	$file = $request->file('image');
            	if($file){
	      			$fileName = 'profile_'.md5(time()).'.'.$file->getClientOriginalExtension();
	      			$file->move($this->profileFolder, $fileName);  	
	      			$user->image = $fileName;
            	}         
	      	
    			$user->first_name = $request->first_name;
    			$user->last_name = $request->last_name;
    			$user->email = $request->email;
    			$user->mobile = $request->mobile;
    			$user->address = $request->address;
    			$user->save();
    			return back()->with('success','Details updated successfully!');		
    		}else{
    			return back()->with('failed','User not found');
    		}
    	}
    }

}
