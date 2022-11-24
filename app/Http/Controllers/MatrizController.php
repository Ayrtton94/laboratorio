<?php

namespace App\Http\Controllers;

use App\Models\Matriz;
use App\Http\Requests\MatrizRequest;
use Illuminate\Database\QueryException;
use App\Http\Resources\MatrizCollection;

class MatrizController extends Controller
{

	public function index()
	{
		return view('matrices.index');
	}

	public function columns()
    {
        return [
            'description' => 'Descripción'
        ];
    }
    public function records(MatrizRequest $request)
    {
        $records = Matriz::where(function ($query) use($request) {
				if($request->column) return $query->where($request->column, 'like', "%{$request->value}%");
			})->latest();
        return new MatrizCollection($records->paginate(env('ITEMS_PER_PAGE', request('per_page'))));
	}

	public function record($id)
    {
        $record = Matriz::findOrFail($id)->toArray();
        return ['data' => $record];
    }

	public function store(MatrizRequest $request)
	{
		try {

            $id = $request->input('id');
            $matriz = Matriz::firstOrNew(['id' => $id]);
            $matriz->fill($request->all());
            $matriz->save();

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
        $record = Matriz::findOrFail($id);
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
        $record = Matriz::findOrFail($id);
        $record->update([
			'estado' => 1
		]);

        return [
            'success' => true,
            'message' => 'Resturada con éxito'
        ];
	}
}
