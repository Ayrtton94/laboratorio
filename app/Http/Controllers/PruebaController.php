<?php

namespace App\Http\Controllers;

use App\Models\Matriz;
use App\Models\Prueba;
use App\Http\Requests\PruebaRequest;
use Illuminate\Database\QueryException;
use App\Http\Resources\PruebaCollection;
use App\Models\Laboratorio;
use App\Models\Metodo;
use App\Models\Muestra;

class PruebaController extends Controller
{

	public function index()
	{
		return view('pruebas.index');
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
		$pruebas = Prueba::with('muestra','matriz','laboratorio','metodo')->get();
		return response()->json([
			'pruebas' => $pruebas
		]);
        
	}

	public function record($id)
    {
        $record = Prueba::findOrFail($id)->toArray();
        return ['data' => $record];
    }

	public function tables()
    {
		$matrices = Matriz::orderBy('description')->get();
        $muestras = Muestra::orderBy('description')->get();
		$laboratorios = Laboratorio::orderBy('name')->get();
		$metodos = Metodo::orderBy('name')->get();
        return compact('muestras','matrices','laboratorios','metodos');
    }

	public function store(PruebaRequest $request)
	{
		try {

            $id = $request->input('id');
            $prueba = Prueba::firstOrNew(['id' => $id]);
            $prueba->fill($request->all());
            $prueba->save();

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
        $record = prueba::findOrFail($id);
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
        $record = prueba::findOrFail($id);
        $record->update([
			'estado' => 1
		]);

        return [
            'success' => true,
            'message' => 'Resturada con éxito'
        ];
	}
}
