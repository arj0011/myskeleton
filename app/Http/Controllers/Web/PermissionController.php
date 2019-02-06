<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\DataTables\PermissionsDataTable;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(PermissionsDataTable $dataTable,Request $request) {
        
        return $dataTable->render('backend.permissions.index');

    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create() {
        $roles = Role::get(); //Get all roles
        return view('backend.permissions.create')->with('roles', $roles);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
        $this->validate($request, [
            'name'=>'required|unique:permissions|max:40',
        ]);

        $name = $request['name'];

        $permission = new Permission();
        $permission->name = $name;

        $roles = $request['roles'];

        $permission->save();

        if (!empty($request['roles'])) { 
        	//If one or more role is selected
            foreach ($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail(); 
                //Match input role to db record

                $permission = Permission::where('name', '=', $name)->first(); 
                //Match input 
                //permission to db record
                $r->givePermissionTo($permission);
            }
        }

        return back()->with('success','Permission '. $permission->name.' added!');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id) {
    	$permissions = Permission::where('id', '=', $id)->firstOrFail();
        return view('backend.permissions.edit')->with('permissions', $permissions);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id) {
        $permission = Permission::findOrFail(decrypt($id));

        return view('backend.permissions.edit', compact('permission'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id) {
        $permission = Permission::findOrFail(decrypt($id));
        $this->validate($request, [
            'name'=>'required|max:40|unique:permissions,name,'.decrypt($id),
        ]);
        $input = $request->all();
        $permission->fill($input)->save();
        return back()->with('success','Permission '. $permission->name.' updated!');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request) {
        
        if($request->ajax()){
            $input = $request->only('permission_id');
            $validator=Validator::make($input,[
                'permission_id'=>'required'
            ]);
            if($validator->fails()){
                $response = ['status' =>0,'message' => 'Something went wrong'];
            }else{
                $permission = Permission::findOrFail(decrypt($request->permission_id));
                $affectrow = $permission->delete();
                if($affectrow){
                    $response = ['status' =>1,'message' => 'Permission '. $permission->name.' deleted!'];
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
