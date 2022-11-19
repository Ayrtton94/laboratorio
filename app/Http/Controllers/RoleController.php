<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(){
		$permissionsall = Permission::get();
		return view('roles.index', compact('permissionsall'));
	}

	public function records(){
		$roles = Role::all();
		return response()->json([
			'roles' => $roles
		]);
	}

	public function create(){
		
		return view('roles.form');
	}

	public function getPermission(){

		$permissions = Permission::all();
		return response()->json([
			'permissions' => $permissions
		]);
	}
	
	public function store(Request $request){
		
		$role = Role::create([
			'name'=>$request->input('name'),
			'description'=>$request->input('description')
		]);
		$role->syncPermissions($request->input('permissions'));
		return [
			'success' => true,
			'message' => 'Registro Exitoso'
		];
	}

	public function editroles($id){
		$roleData = Role::find($id);
		return response()->json(['roledata' => $roleData]);
	}

	public function querypermisos($id)
	{
		$rolepermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)->get();
		return response()->json(['data' => $rolepermissions]);
	}

	public function update(Request $request)
    {
		$role = Role::find($request->id);
		$role->name = $request->input('name');
		$role->description = $request->input('description');
		$role->save();
		$role->syncPermissions($request->input('permissions'));
		return [
			'success' => true,
			'message' => 'Registro Actualizado'
		];
    }

	public function destroy($id){
		$request = DB::table('roles')->where('id', $id)->delete();
		return response()->json(['request' => $request]);
	}
}
