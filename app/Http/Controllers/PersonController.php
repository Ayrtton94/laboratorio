<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Person;
use App\Models\Country;
use App\Models\District;
use App\Models\Province;
use App\Models\Department;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\IdentityDocument;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PersonRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PersonCollection;

class PersonController extends Controller
{
	
    public function index($type)
    {
		return view('persons.index', compact('type'));
    }

	public function store(PersonRequest $request)
    {
        $id = $request->input('id');
        $person = Person::firstOrNew(['id' => $id]);
        $person->fill($request->all());
		
        $person->save();
		
		if($request->type == 'staff' && !!$request->user_account)
		{
			if($id)
			{
				$user = User::where('staff_id', $id)->first();
				if($user){
					$user->update([
						'name' =>$request->name,
						'email' => $request->username,
						'password' => !empty($request->userpassword) ? Hash::make($request->userpassword) : $user->password
					]);
					DB::table('model_has_roles')->where('model_id', $user->id)->delete();
					$user->assignRole($request->rol);
				}else{
					User::create(['name' =>$request->name,'email' =>$request->username,'password' => Hash::make($request->userpassword),'staff_id'=> $person->id])->assignRole($request->rol);
				}
			}
			else{
				$user = User::create([
					'name' =>$request->name,
					'email' =>$request->username,
					'password' => Hash::make($request->userpassword),
					'staff_id'=> $person->id
				]);
				$user->assignRole($request->rol);
			}
		}
		
        return [
            'success' => true,
            'message' => ($id) ? 'Datos Actualizados' : 'Registrado con éxito',
            'id' => $person->id
        ];
    }

	public function search()
	{
		$search = request('search');
		
		$persons = Person::whereType('customers')->with('identity_document')->without('country', 'department', 'province', 'district')
				->where('name', 'like', '%'. $search.'%')
				->orWhere('number',$search)
				->orWhere('number', 'like', '%'. $search.'%')
				->orderBy('name')
				->get()
				->transform(function ($row) {
					return [
						'id' => $row->id,
						'description' => $row->number . ' - ' . $row->name,
						'name' => $row->name,
						'number' => $row->number
					];
				});
				
		return $persons;
	}

	public function columns()
    {
        return [
            'name' => 'Nombre',
			'number' => 'Número Documento',
			'telephone' => 'Teléfono',
			'email' => 'Correo Electrónico',
			'address' => 'Dirección',
        ];
    }

	public function records($type, Request $request)
    {
		
		$records = Person::with('user.roles')->withTrashed()->where('type', $type);
		if(!!$request->column && !!$request->value){
			$records->where($request->column, 'like', "%{$request->value}%");
		}
		$records = 	$records->without('country', 'department', 'province', 'district')
                            ->orderBy('name');
		
        return new PersonCollection($records->paginate(env('ITEMS_PER_PAGE', request('per_page'))));
        
    }

	public function totals(){
		
	}

	public function tables()
    {
        $departments = Department::where('active',1)->orderBy('description')->get();
        $provinces = Province::where('active',1)->orderBy('description')->get();
        $districts = District::where('active',1)->orderBy('description')->get();
        $identity_document_types = IdentityDocument::where('status',1)->get();

        return compact('departments', 'provinces', 'districts', 'identity_document_types');
    }

    public function destroy($id)
    {
        $person = Person::findOrFail($id);
		$person->update(['status' => 0]);
		$person->delete();

		return [
			'success' => true,
			'message' => 'Cliente Eliminado con exito'
		];
    }

	public function restore($id)
    {
        $person = Person::withTrashed()->findOrFail($id);
		$person->update(['status' => 1]);
		$person->restore();

		return [
			'success' => true,
			'message' => 'Cliente Restaurado con exito'
		];
    }
}
