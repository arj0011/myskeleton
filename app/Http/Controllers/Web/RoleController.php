<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\DataTables\RolesDataTable;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RolesDataTable $dataTable,Request $request) {
        
        return $dataTable->render('backend.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $permissions = Permission::all();//Get all permissions

        return view('backend.roles.create', ['permissions'=>$permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
    //Validate name and permissions field
        $this->validate($request, [
            'name'=>'required|unique:roles|max:10',
            'permissions' =>'required',
            ]
        );

        $name = $request['name'];
        $role = new Role();
        $role->name = $name;

        $permissions = $request['permissions'];

        $role->save();
    	//Looping thru selected permissions
        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); 
         //Fetch the newly created role and assign permission
            $role = Role::where('name', '=', $name)->first(); 
            $role->givePermissionTo($p);
        }
        return back()->with('success','Role '. $role->name.' added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
    	$permissions = Permission::all(); //Get all permissions
    	$role = Role::where('id', '=', $id)->firstOrFail();
        return view('backend.roles.edit',compact('permissions','role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $role = Role::findOrFail(decrypt($id));
        $permissions = Permission::all();

        return view('backend.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        //Get role with the given id
        $role = Role::findOrFail(decrypt($id));
    	//Validate name and permission fields
        $this->validate($request, [
            'name'=>'required|max:10|unique:roles,name,'.decrypt($id),
            'permissions' =>'required',
        ]);
        
        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();

        $p_all = Permission::all();//Get all permissions

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p); //Remove all permissions associated with role
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
            $role->givePermissionTo($p);  //Assign permission to role
        }
        return back()->with('success','Role '. $role->name.' updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($request->ajax()){
    
            $input = $request->only('role_id');
            $validator=Validator::make($input,[
                'role_id'=>'required'
            ]);
            if($validator->fails()){
                $response = ['status' =>0,'message' => 'Something went wrong'];
            }else{
                $role = Role::findOrFail(decrypt($request->role_id));
                $affectrow = $role->delete();
                if($affectrow){
                    $response = ['status' =>1,'message' => 'Role '. $role->name.' deleted!'];
                }else{
                    $response = ['status' =>0,'message' => 'Record not found'];
                }
            }    
        }else{
            $response = ['status' =>0,'message' => 'Invalid Request'];
        }
        
        return response()->json($response);
    }

}
