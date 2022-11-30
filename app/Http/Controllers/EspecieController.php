<?php

namespace App\Http\Controllers;

use App\Models\Especie;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EspecieRequest;
use Illuminate\Database\QueryException;
use App\Http\Resources\EspecieCollection;

class EspecieController extends Controller
{

	public function index()
	{
		return view('especies.index');
	}

	public function columns()
    {
        return [
            'description' => 'Descripción'
        ];
    }
    public function records()
    {
		$especies = Especie::all();
		return response()->json([
			'especies' => $especies
		]);
	}

	public function record($id)
    {
        $record = Especie::findOrFail($id)->toArray();
        return ['data' => $record];
    }

	public function store(EspecieRequest $request)
	{
		try {

            $id = $request->input('id');
            $especie = Especie::firstOrNew(['id' => $id]);
            $especie->fill($request->all());
            $especie->save();

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
        $record = Especie::findOrFail($id);
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
        $record = Especie::findOrFail($id);
        $record->update([
			'estado' => 1
		]);

        return [
            'success' => true,
            'message' => 'Resturada con éxito'
        ];
	}
}
