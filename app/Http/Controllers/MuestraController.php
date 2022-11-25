<?php

namespace App\Http\Controllers;


use App\Models\Matriz;
use App\Models\Muestra;
use App\Http\Requests\MatrizRequest;
use App\Http\Requests\MuestraRequest;
use Illuminate\Database\QueryException;
use App\Http\Resources\MuestraCollection;

class MuestraController extends Controller
{

	public function index()
	{
		return view('muestras.index');
	}

	public function columns()
    {
        return [
            'description' => 'Descripción'
        ];
    }
    public function records()
    {
		$muestras = Muestra::with('matriz')->get();
		return response()->json([
			'muestras' => $muestras
		]);
	}

	public function record($id)
    {
        $record = Muestra::findOrFail($id)->toArray();
        return ['data' => $record];
    }

	public function tables()
    {
        $matrices = Matriz::orderBy('description')->get();
        return compact('matrices');
    }

	public function store(MuestraRequest $request)
	{
		try {

            $id = $request->input('id');
            $muestra = Muestra::firstOrNew(['id' => $id]);
            $muestra->fill($request->all());
            $muestra->save();

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
        $record = Muestra::findOrFail($id);
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
        $record = Muestra::findOrFail($id);
        $record->update([
			'estado' => 1
		]);

        return [
            'success' => true,
            'message' => 'Resturada con éxito'
        ];
	}
}
