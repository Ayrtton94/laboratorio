<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Muestra;
use App\Models\ProgramaBrucella;
use Illuminate\Database\QueryException;
use App\Http\Requests\ProgramaBrucellaRequest;

class ProgramaBrucellaController extends Controller
{

	public function index()
	{
		return view('programabrucellas.index');
	}

	public function columns()
    {
        return [
            'name' => 'Descripción',
			'condicion' => 'Condicion',
        ];
    }
    public function records()
    {
        $program = ProgramaBrucella::with('muestra','supplier')->get();
		return response()->json([
			'program' => $program
		]);

	}

	public function record($id)
    {
        $record = ProgramaBrucella::findOrFail($id)->toArray();
        return ['data' => $record];
    }

	public function tables()
    {
        $muestras = Muestra::orderBy('description')->get();
        $suppliers = Person::whereType('suppliers')->without('country', 'department', 'province', 'district')->limit(5)->get()->transform(function ($row) {
            return [
                'id' => $row->id,
                'description' => $row->number . ' - ' . $row->name,
                'name' => $row->name,
                'number' => $row->number,
                'identity_document_type_id' => $row->identity_document_type_id,
//                'identity_document_type_code' => $row->identity_document_type->code
            ];
        });
        return compact('muestras','suppliers');
    }

	public function store(ProgramaBrucellaRequest $request)
	{
		try {

            $id = $request->input('id');
            $programbruce = ProgramaBrucella::firstOrNew(['id' => $id]);
            $programbruce->fill($request->all());
            $programbruce->save();

            return [
                'success' => true,
                'message' => ($id) ? 'Editado con éxito' : 'Registrada con éxito'
            ];

        } catch (QueryException $e) {

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];

        }

	}


	public function destroy($id)
    {
        $record = ProgramaBrucella::findOrFail($id);
        $record->update([
			'estado' => 0
		]);

        return [
            'success' => true,
            'message' => 'Eliminada con éxito'
        ];
	}

	public function restore($id)
    {
        $record = ProgramaBrucella::findOrFail($id);
        $record->update([
			'estado' => 1
		]);

        return [
            'success' => true,
            'message' => 'Resturada con éxito'
        ];
	}
}
