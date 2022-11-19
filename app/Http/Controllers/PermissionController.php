<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
	public function index(){
		return view('permissions.index');
	}

	public function records(){
		$permissions = Permission::all();
		return response()->json([
			'data' => $permissions
		]);
	}
}
