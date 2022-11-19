<?php

namespace App\Http\ViewComposers;

use App\Models\User;
use Spatie\Permission\Models\Permission;


class PermissionsViewComposer
{
    public function compose()
    {
		$userData = User::with('roles.permissions')->findOrFail(auth()->id());
		$permissions = collect();
		$roles = $userData->roles->map(function($rol) use(&$permissions){
			$permissions = $permissions->merge($rol->permissions);
			
			return ['name' => $rol->name, 'guard_name' => $rol->guard_name];
		});
		
		if($userData->hasRole('admin'))
		{
			$permissions = Permission::all();
		}else{
			$permissions = $permissions->merge($userData->permissions)->map(function($per) {
				return ['name' => $per->name, 'guard_name' => $per->guard_name];
			})->unique();
		}

		$data =  [
            'name' => $userData->name,
            'email' =>$userData->email,
            'permissions' => $permissions,
            'roles' => $roles
        ];

		session()->put('permissions_roles',$data);
		session()->put('permisos',$permissions);
		session()->put('roles',$roles);
    }
}