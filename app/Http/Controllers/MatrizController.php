<?php

namespace App\Http\Controllers;

use App\Models\Presentacion;
use Illuminate\Database\QueryException;
use App\Http\Requests\PresentacionRequest;
use App\Http\Resources\PresentacionCollection;

class PresentacionController extends Controller
{

	public function index()
	{
		return view('presentaciones.index');
	}

	public function columns()
    {
        return [
            'description' => 'Descripción'
        ];
    }
    public function records(PresentacionRequest $request)
    {
        $records = Presentacion::where(function ($query) use($request) {
				if($request->column) return $query->where($request->column, 'like', "%{$request->value}%");
			})->latest();
        return new PresentacionCollection($records->paginate(env('ITEMS_PER_PAGE', request('per_page'))));
	}

	public function record($id)
    {
        $record = Presentacion::findOrFail($id)->toArray();
        return ['data' => $record];
    }

	public function store(PresentacionRequest $request)
	{
		try {

            $id = $request->input('id');
            $presentacion = Presentacion::firstOrNew(['id' => $id]);
            $presentacion->fill($request->all());
            $presentacion->save();

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
        $record = Presentacion::findOrFail($id);
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
        $record = Presentacion::findOrFail($id);
        $record->update([
			'estado' => 1
		]);

        return [
            'success' => true,
            'message' => 'Resturada con éxito'
        ];
	}
}
