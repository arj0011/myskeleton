<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class AuthController extends ApiController
{
    protected $uploadsFolder='public/uploads/users/';

    public function login(Request $request){
    	$input=$request->only('email', 'password');
       
    	$validator=Validator::make($input,[
      		'email'=>'required|email|max:255',
      		'password'=>'required|min:6'    
    	]);
    	if($validator->fails()){
      		return parent::api_response([], false, $validator->errors()->first(), 200);
    	}else{
      
	      	$jwt = '';
	      	$credentials['email'] = $input['email'];
	      	$credentials['password'] = $input['password'];
	      	$useremail=User::where('email',$credentials['email'])->first();
	      	if(!$useremail){
	        	return parent::api_response([],false,'email not exist', 200);
	      	}         

	      	$user=User::where('email',$credentials['email'])
	               ->where('status',1)
	               ->first();        
	      	if($user){
	        	try{
	          		if(!$jwt=JWTAuth::attempt($credentials)){
	            		return parent::api_response([],false,'Password not match', 200);
	          		}
	        	}catch(JWTAuthException $e){
	          		return parent::api_response([],false,'Authtoken not generated', 400);
	        	}
        
	        	$user = User::findOrFail(Auth::user()->id);
	        	$user->auth_token=$jwt;
	        	$user->device_type=$request->device_type;
	        	$user->device_token=$request->device_token;

	        	if($user->save()){
	          		return parent::api_response($user,true,'Login successfully.',200);
	        	}        
	      	}else{
	        	return parent::api_response([],false,'Your account is deactivated',200);
	      	}
    	}
  	}

	public function getAuthUser(Request $request){
	    $user=JWTAuth::toUser($request->token);
	    return response()->json(['result' => $user]);
	}
  
  	public function register(Request $request)
  	{
    	$data=$request->all();
    	$validator=Validator::make($data,[
	        'name'=>'required|max:255',
	        'email'=>'required|email|max:255',
	        'password'=>'required|min:6',
	        'mobile'=>'required|digits:10',
	        'device_type'=> ['required',Rule::in(['ANDROID', 'IOS']),],
	        'device_token'=>'required',
	        'image'=>'required',
	        'role'=>'required|integer'
    	]);
    
    	if($validator->fails()){
    		return parent::api_response([], false, $validator->errors()->first(), 200);
    	} else{
      		$user=User::where('email',$data['email'])->first();
      		if($user){
        
	        //update device token
	        $user->device_type=$data['device_type'];
	        $user->device_token=$data['device_token'];
	        $user->save();

	        return parent::api_response($user,true,'This email already exist.',200);    
      		}else{
		        $new_user = new User;
		        $new_user->name = isset($data['name'])?$data['name']:'';
		        $new_user->email =isset($data['email'])?$data['email']:"";
		        $new_user->password=isset($data['password'])?bcrypt($data['password']):"";
		        $new_user->mobile=isset($data['mobile'])?$data['mobile']:"";
		        $new_user->device_type=isset($data['device_type'])?$data['device_type']:'';
		        $new_user->device_token=isset($data['device_token'])?$data['device_token']:'';
		        
		        if(isset($data['image']))
		        {
		          	$file = $data['image'];
		          	$newName ='profile_'.md5(time()).'.'.$file->getClientOriginalExtension();
		          	$folder ='';
		          	$file->move($this->uploadsFolder.$folder,$newName);
		          	$new_user->image=$newName;
	        	}
	        	if($new_user->save()){
	        		$role_r = Role::where('id', '=', $request->role)->firstOrFail();
                	$new_user->assignRole($role_r); //Assigning role to user
                	$new_user->role = $request->role;
                	$new_user->save(); 
	          		$user = User::findorFail($new_user->id);
	          		return parent::api_response($user,true,"Successfully signup", 200);
	        	}
        		return parent::api_response([],false,"Signup failed", 200);
      		}
    	}   
  	}

	public function validateVersion($appVersion)
	{
	    if($appVersion == null){
	      	return parent::api_response([], false, ['error' => 'invalid app version parameter'], 200);
	    }
	    if($appVersion<2)
	    {
	      	return parent::api_response([],false,'Please update your app version',200);    
	    }else if($appVersion<3 && $appVersion>2){
	      	return parent::api_response([],'warning',"New app version is available on play store",200);  
	    }else{
	      	return parent::api_response([],true,"Success",200); 
	    }
	}
  
  	public function logout(Request $request){
    	$token=JWTAuth::getToken();
    	if(Auth::logout() || $token){
	      	try{
	        	JWTAuth::invalidate($token);
	        	return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
	      	}catch (JWTException $e) {
	        	// something went wrong whilst attempting to encode the token
	        	return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
	      	}
	      	return $this->api_response([], true, 'Logged out', 200);
    	}
  	}
  
  	public function verifyOtp(Request $request)
  	{
    	$input=$request->only('userId', 'otp');
    	$validator=Validator::make($input,[
        	'userId' =>'required',
        	'otp'=>'required'    
    	]);
        // user_type=1 for user
        // user_type=2 for admin
       
        if($validator->fails()){
            return parent::api_response([], false, $validator->errors()->first(), 200);
        }else{
            $jwt='';
            $user=User::find($input['userId']); 
            if($user){
             	$exists=User::where('id',$input['userId'])
                    ->where('verification_code',$input['otp'])->get();
              	if($exists->count()){ 
                    $user = Auth::loginUsingId($input['userId']);
                    $user = Auth::user();
                    $token=JWTAuth::fromUser($user);
                    $user->auth_token=$token;
                    if(isset($input['device_type']) && $input['device_type'] != '')
                      	$user->device_type = $input['device_type'];
                    
                    if(isset($input['device_token']) && $input['device_token'] != '')
                      	$user->device_type = $input['device_token'];
                    
                    $user->verify=1;
               		if($user->save()){
                   		$user->userId=$user->id;
                   	
                   		unset($user->id);
                		return parent::api_response($user,true,"Otp verified successfully",200);  
               		}
              	}else{
               		return parent::api_response([],false,"Invalide otp",200);   
              	}
           	}else{
             	return parent::api_response([],false,"User id does'nt exists!!",400);    
           	}
        }
    }
}
