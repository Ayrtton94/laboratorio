<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use Illuminate\Database\QueryException;
use App\Http\Requests\LaboratorioRequest;
use App\Http\Resources\LaboratorioCollection;

class LaboratorioController extends Controller
{

	public function index()
	{
		return view('laboratorios.index');
	}

	public function columns()
    {
        return [
            'description' => 'Descripción'
        ];
    }
    public function records()
    {        
		$laboratorios = Laboratorio::all();
		return response()->json([
			'laboratorios' => $laboratorios
		]);
	}

	public function record($id)
    {
        $record = Laboratorio::findOrFail($id)->toArray();
        return ['data' => $record];
    }

	public function store(LaboratorioRequest $request)
	{
		try {

            $id = $request->input('id');
            $laboratorio = Laboratorio::firstOrNew(['id' => $id]);
            $laboratorio->fill($request->all());
            $laboratorio->save();

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
        $record = Laboratorio::findOrFail($id);
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
        $record = Laboratorio::findOrFail($id);
        $record->update([
			'estado' => 1
		]);

        return [
            'success' => true,
            'message' => 'Resturada con éxito'
        ];
	}
}
