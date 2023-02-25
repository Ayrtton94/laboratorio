<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
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
		->select('users.id','users.name','users.last_name','users.email','roles.name as role_name','users.status as status','users.person')
		->join('model_has_roles', function($query){
			$query->on('users.id', '=', 'model_has_roles.model_id');
		})
		->leftJoin('roles', function($query) { $query->on('model_has_roles.role_id', '=', 'roles.id');})->get();
		return ['users' => $users];
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required',
			'email' => 'required',
			'person' => 'required',
			'rol' => 'required'

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

	public function update(Request $request)
	{
		$this->validate($request,[
			'name' => 'required',
			'email' => 'required',
			'person' => 'required',
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
		$user = User::findOrFail($id);
		$user->update(['status' => 0]);

		return [
            'success' => true,
            'message' => 'Eliminada con éxito'
		];
	}

	public function restore($id)
    {
        $record = User::findOrFail($id);
        $record->update(['status' => 1]);

        return [
            'success' => true,
            'message' => 'Resturada con éxito'
        ];
	}
}
