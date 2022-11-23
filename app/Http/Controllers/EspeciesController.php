<?php

namespace App\Http\Controllers;

use App\Models\Especie;
use App\Models\Presentacion;
use App\Http\Requests\EspecieRequest;
use Illuminate\Database\QueryException;
use App\Http\Resources\EspecieCollection;
use App\Http\Requests\PresentacionRequest;
use App\Http\Resources\PresentacionCollection;

class EspeciesController extends Controller
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
    public function records(PresentacionRequest $request)
    {
        $records = Especie::where(function ($query) use($request) {
				if($request->column) return $query->where($request->column, 'like', "%{$request->value}%");
			})->latest();
        return new EspecieCollection($records->paginate(env('ITEMS_PER_PAGE', request('per_page'))));
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
