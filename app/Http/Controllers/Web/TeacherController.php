<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\DataTables\TeachersDataTable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use Auth;
use App\Exports\TeachersExport;
use App\Imports\TeachersImport;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    public function index(TeachersDataTable $dataTable,Request $request)
    {
        return $dataTable->render('backend.teachers.teachers');
    }

    public function createTeacher(Request $request)
    {
        return view('backend.teachers.createteacher');
    }

    public function storeTeacher(Request $request)
    {
        $input = $request->all();
        $validate = Validator::make($input,[
            'name'=>'required|max:255',
            'email'=>'required|email|max:255|unique:users'
        ]);
        if($validate->fails()){
            return back()->withErrors($validate);
        }else{
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt(123456);
            $user->role = 3;//Teacher 
            if($user->save()){
                $role_r = Role::where('id', '=', 3)->firstOrFail();            
                $user->assignRole($role_r); //Assigning role to user         
                return back()->with('success','Register successfully');
            }else{
                return back()->with('failed','Failed to register');
            }   
        }
    }

    public function showEditTeacher($user_id)
    {	
    	$user = User::find(decrypt($user_id));
        $roles = Role::get(); //Get all roles
    	if($user){
    		return view('backend.teachers.editteacher',compact('user','roles'));
    	}else{
    		return back()->with('failed','User not found');
    	}

    }

    public function updateTeacher(Request $request)
    {	
    	$input = $request->all();
    	$validate = Validator::make($input,[
    		'name'=>'required|max:255',
    		'email'=>'required|email|max:255',
    		'status'=>['required',Rule::in([1, 0]),]
    	]);
    	if($validate->fails()){
    		return back()->withErrors($validate);
    	}else{
    		$user = User::find(decrypt($request->user_id));
	    	if($user){
				$exist = User::where('id','!=',decrypt($request->user_id))		    	->where('email',$request->email)->first();
				if($exist){
					return back()->with('failed','Email already exist');	
				}else{
					$user->name = $request->name;
					$user->email = $request->email;
                    $user->status = $request->status;
					$user->role = $request->roles;
					if($user->save()){
                        $roles = $request->roles; //Retreive all roles
                        if (isset($roles)) {        
                            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles          
                        }        
                        else {
                            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
                        }
						return back()->with('success','Teacher updated successfully');
                    }
					else
						return back()->with('failed','Teacher not updated');
				}
	    	}else{
	    		return back()->with('failed','Teacher not found');
	    	}	
    	}
    	
    }

    public function removeTeacher(Request $request){
	    if($request->ajax()){
	      	$input = $request->only('user_id');
	      	$validator=Validator::make($input,[
	        	'user_id'=>'required'
	      	]);
	      	if($validator->fails()){
	        	$response = ['status'=>0,'message' => 'Something went wrong']; 
	      	}else{
	        	$affectrow = User::where('id',decrypt($input['user_id']))->delete();
	        	if($affectrow){
	          	$response = ['status' =>1,'message' => 'Record removed successfully'];
	        	}else{
	          		$response = ['status' =>0,'message' => 'Record not found'];   
	        	}
	      	}
	    }else{
	      $response = ['status' =>0,'message' => 'Invalid Request'];
	    }
    	return response()->json($response);
  	}

  	public function deleteAllTeacher(Request $request)
    {
        $ids = $request->ids;
        User::whereIn('id',explode(",",$ids))->delete();
        return response()->json(['status'=>1,'message'=>"Teachers Deleted successfully."]);
    }

  	public function viewTeacher(Request $request)
  	{
  		if($request->ajax()){
	      	$input = $request->only('user_id');
	      	$validator=Validator::make($input,[
	        	'user_id'=>'required'
	      	]);
	      	if($validator->fails()){
	        	$response = ['status'=>0,'message' => 'Something went wrong']; 
	      	}else{
	        	$userData = User::where('id',decrypt($input['user_id']))->first();
	        	if($userData){
	        		$view = view("backend.teachers.viewteacher",compact('userData'))->render();
	          		$response = ['status' =>1,'html' => $view];
	        	}else{
	          		$response = ['status' =>0,'message' => 'Record not found'];   
	        	}
	      	}
	    }else{
	      $response = ['status' =>0,'message' => 'Invalid Request'];
	    }
    	return response()->json($response);
  	}

  	/**
    * Export Teachers
    * Referense https://laravel-excel.maatwebsite.nl/3.1/imports/heading-row.html
    */
  	public function exportTeacherData(Request $request)
    {
    	$user = User::select('name','email', 'created_at');
    	$user->selectRaw('IF(status = 1,"Active","Deactive")');
    	if($request->startDate) {
            $st = $request->startDate;
            $dt = ($request->endDate == '') ? date('Y-m-d') : $request->endDate;
            $user->whereDate('created_at','<=', "$dt");
            $user->whereDate('created_at','>=', "$st");
        }
        if($request->status == '0' || $request->status == '1') {
            $user->where('status', $request->status);
        } 
        $user->where('role','3');           
       	$users = $user->get();
    	return Excel::download(new TeachersExport($users), 'Teachers.'.$request->type);
    	
    	// return Excel::download(new UsersExport, 'users.xlsx');
    }

    /**
    * Import Users
    * Referense https://laravel-excel.maatwebsite.nl/3.1/imports/heading-row.html
    */
    
    public function importTeacherData(Request $request)
    {
    	$request->validate([
    		'import_file' => 'required'
		]);

    	$validator = Validator::make(
	  	[
	     	'extension' => strtolower($request->import_file->getClientOriginalExtension()),
	  	],
	  	[
	      	'extension' => 'required|in:csv,xlsx,xls,odt,ods,odp',
	  	]
		);

    	if($validator->fails()) {
    		return back()->with('failed',$validator->errors()->first());
    	}else{
    		Excel::import(new TeachersImport, $request->file('import_file'));	
    		return back()->with('success','Teachers data import successfully');
    	}
    	
    }

  	// Download import file format
  	public function downloadFormat()
	{
	    //Excel file is stored under project/public/download/info.xls
	    $file= public_path(). "/download/teachersformat.xls";
	    
	    $headers = ['Content-Type' => 'application/vnd.ms-excel'];
		return response()->download($file, 'teachersformat.xls', $headers);
	}
}
