<?php

namespace App\Http\Controllers;

use App\Models\Especie;
use App\Models\SubEspecie;
use App\Models\Presentacion;
use App\Http\Requests\EspecieRequest;
use Illuminate\Database\QueryException;
use App\Http\Requests\SubEspecieRequest;
use App\Http\Resources\EspecieCollection;
use App\Http\Requests\PresentacionRequest;
use App\Http\Resources\SubEspecieCollection;
use App\Http\Resources\PresentacionCollection;

class SubEspecieController extends Controller
{

	public function index()
	{
		return view('subespecies.index');
	}

	public function columns()
    {
        return [
            'description' => 'Descripción'
        ];
    }
    public function records()
    {
		$subespecies = SubEspecie::with('especie')->get();
		return response()->json([
			'subespecies' => $subespecies
		]);
	}

	public function record($id)
    {
        $record = SubEspecie::findOrFail($id)->toArray();
        return ['data' => $record];
    }

	public function tables()
    {
        $especies = Especie::orderBy('description')->get();
        return compact('especies');
    }

	public function store(SubEspecieRequest $request)
	{
		try {
			if ($request->especie_id == null) {
                return [
                    'success' => false,
                    'message' => 'Seleccione una Especie'
                ];
            }
            $id = $request->input('id');
            $especie = SubEspecie::firstOrNew(['id' => $id]);
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
        $record = SubEspecie::findOrFail($id);
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
        $record = SubEspecie::findOrFail($id);
        $record->update([
			'estado' => 1
		]);

        return [
            'success' => true,
            'message' => 'Resturada con éxito'
        ];
	}
}
