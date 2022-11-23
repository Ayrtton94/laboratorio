<?php

namespace App\Http\Controllers;

use App\Models\Matriz;
use App\Models\Muestra;
use App\Models\Presentacion;
use App\Http\Requests\MatrizRequest;
use App\Http\Requests\MuestraRequest;
use Illuminate\Database\QueryException;
use App\Http\Resources\MatrizCollection;
use App\Http\Requests\PresentacionRequest;
use App\Http\Resources\PresentacionCollection;

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
    public function records(MuestraRequest $request)
    {
        $records = Muestra::where(function ($query) use($request) {
				if($request->column) return $query->where($request->column, 'like', "%{$request->value}%");
			})->latest();
        return new MMuestraCollection($records->paginate(env('ITEMS_PER_PAGE', request('per_page'))));
	}

	public function record($id)
    {
        $record = Muestra::findOrFail($id)->toArray();
        return ['data' => $record];
    }

	public function store(MatrizRequest $request)
	{
		try {

            $id = $request->input('id');
            $presentacion = Muestra::firstOrNew(['id' => $id]);
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
