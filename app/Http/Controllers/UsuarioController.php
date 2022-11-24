<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{

	public function index()
	{
		$user = User::all();
		return view('usuarios.index', compact('user'));
	}

	public function create()
	{
		return view('usuarios.form');
	}

	public function records()
	{
		$users = DB::table('users')
		->select('users.id','users.name','users.last_name','users.email','roles.name as role_name')
		->join('model_has_roles', function($query){
			$query->on('users.id', '=', 'model_has_roles.model_id');
		})
		->leftJoin('roles', function($query) { $query->on('model_has_roles.role_id', '=', 'roles.id');})
		->where('status',1)->paginate(5);
		return ['users' => $users];
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|unique:users',
			'password' => 'required',
			'rol' => 'required',
			'document' => 'required|unique:users'
		]);

		$input = $request->all();

		$input['password'] = Hash::make($input['password']);
		$user = User::create($input);
		$user->assignRole($request->input('rol'));
		
		return [
			'success' => true,
			'message' => 'Usuario registrado'
		];
	}

	public function edit($id)
	{
		$usuarios = User::with('roles')->where('id',$id)->first();
		return view('usuarios.editar', compact('usuarios'));
	}

	public function searchuser()
	{
		$roles = Role::all();
		return view('usuarios.search', compact('roles'));
	}

	public function search(Request $request)
	{

		$users = DB::table('users')
		->select('users.id','users.name','users.last_name','users.email','roles.name as role_name')
		->join('model_has_roles', function($query) use($request){
			$query->on('users.id', '=', 'model_has_roles.model_id');
			if (!!$request->rol) return $query->where('model_has_roles.role_id', $request->rol);
		})
		->leftJoin('roles', function($query) { $query->on('model_has_roles.role_id', '=', 'roles.id');})
		->where(function ($query) use($request){
			if (!!$request->specialty_id) return $query->where('users.specialty_id', $request->specialty_id);
			if (!!$request->names) return $query->where('users.email', 'like', "%{$request->names}%");
			if (!!$request->email) return $query->where('users.email', 'like', "%{$request->email}%");
		})->where('status',1)->paginate(5);

		return ['users' => $users];
	}

	public function update(Request $request)
	{

		$this->validate($request,[
			'name' => 'required',
			'email' => 'required',
			'rol' => 'required'
		]);
		$input = $request->all();
		if(!empty($input['password'])){
			$input['password'] = Hash::make($input['password']);
		}else{
			$input = Arr::except($input, array('password'));
		}
		$user = User::find($request->id);
		$user->update($input);
		DB::table('model_has_roles')->where('model_id', $request->id)->delete();

		$user->assignRole($request->input('rol'));

		return [
			'success' => true,
			'message' => 'Registro actualizado'
		];
	}

	public function destroy($id)
	{
		$request = DB::table('users')->where('id', $id)->delete();
		return response()->json(['request' => $request]);
	}
}
