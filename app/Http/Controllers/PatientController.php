<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Patient;
use App\Models\Province;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\PatientRequest;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{

	public function index()
	{
		return view('patients.index');
	}


	public function create()
	{
		return view('patients.form');
	}

	public function store(PatientRequest $request)
	{

		$id = $request->id;
		// $paciente = Patient::where('document', $request->document)->first();
		// if (!!$paciente) return ['status' => false, 'message' => 'Ya existe un paciente registrado con el mismo documento'];
		$patient = Patient::firstOrNew(['id' => $id]);
		$patient->fill($request->all());
		!$id ? $patient->save() : $patient->update();

		return [
			'status' => true,
			'message' => !$id ? 'registrado' : 'actualizado'
		];
	}

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $name = $imagen->getClientOriginalName();
            $patient = Patient::where('id',$request->id)->first();
            Storage::delete($patient->path_imagen);
            $path_imagen = $imagen->store('public/files');
            $patient->update([
                'imagen' => $name,
                'path_imagen' => $path_imagen
            ]);

            return [
                'status' => true,
                'message' => 'Imagen cargada'
            ];
        }
    }

	public function means()
	{
		$countries = Country::all();
		// $departments = Department::all();
		$departments = Department::all();
		$provinces = Province::all();
		return [
			'countries' => $countries,
			'departments' => $departments,
			'provinces' => $provinces
		];
	}

	public function update(Request $request, $id)
	{
		//
	}

	public function destroy($id)
	{
		//
	}

	public function records()
	{
		$patients = Patient::paginate(2);
		// $patients = Patient::all();
		return ['patients' => $patients];
	}

	public function search(Request $request)
	{
		// $patients = Patient::where('name','like',"%{$request->names}%")
		// ->orWhere('document','like', "%{$request->document}%")
		// ->paginate(10);
		$patients = Patient::where(function ($query) use ($request) {
			if (!!$request->names) return  $query->where('name', 'like', "%{$request->names}%");
			if (!!$request->document) return  $query->where('document', 'like', "%{$request->document}%");
			if (!!$request->phone) return  $query->where('phone', 'like', "%{$request->phone}%");
		})->paginate(10);
		return ['patients' => $patients];
	}
}
