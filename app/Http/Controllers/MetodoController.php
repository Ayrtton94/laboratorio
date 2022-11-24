<?php

namespace App\Http\Controllers;

use App\Models\Metodo;
use App\Http\Requests\MetodoRequest;
use Illuminate\Database\QueryException;
use App\Http\Resources\MetodoCollection;

class MetodoController extends Controller
{

	public function index()
	{
		return view('metodos.index');
	}

	public function columns()
    {
        return [
            'description' => 'Descripción'
        ];
    }
    public function records(MetodoRequest $request)
    {
        $records = Metodo::where(function ($query) use($request) {
				if($request->column) return $query->where($request->column, 'like', "%{$request->value}%");
			})->latest();
        return new MetodoCollection($records->paginate(env('ITEMS_PER_PAGE', request('per_page'))));
	}

	public function record($id)
    {
        $record = Metodo::findOrFail($id)->toArray();
        return ['data' => $record];
    }

	public function store(MetodoRequest $request)
	{
		try {

            $id = $request->input('id');
            $metodo = Metodo::firstOrNew(['id' => $id]);
            $metodo->fill($request->all());
            $metodo->save();

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
        $record = Metodo::findOrFail($id);
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
        $record = Metodo::findOrFail($id);
        $record->update([
			'estado' => 1
		]);

        return [
            'success' => true,
            'message' => 'Resturada con éxito'
        ];
	}
}
