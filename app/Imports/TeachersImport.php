<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
// use Illuminate\Support\Facades\Validator;
use Hash;
use Spatie\Permission\Models\Role;

class TeachersImport implements ToModel, WithHeadingRow,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $rows)
    {
        // Validator::make($rows, [
        //      'name'     => 'required|string|max:255',
        //      'email'    => 'required|string|email|max:255|unique:users',
        //      'password' => 'required|max:6',
        //  ])->validate();

        $user = new User;
        $user->name = $rows['name'];
        $user->email = $rows['email'];
        $user->password = Hash::make($rows['password']);
        $user->status = 1;
        $user->role = 3;//Teacher 
        if($user->save()){
            $role_r = Role::where('id', '=', 3)->firstOrFail();            
            $user->assignRole($role_r); //Assigning role to user         
        }    
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|max:6',
        ];
    }

}
