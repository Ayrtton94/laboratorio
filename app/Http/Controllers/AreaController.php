<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Requests\AreaRequest;

class AreaController extends Controller
{
	public function index()
	{
		return view('area.index');
	}

	public function records()
	{
		// $areas = Area::where('estado', 1)->get();
		// return response()->json(['areas' => $areas]);
		
		$areas = Area::where('estado', 1)->paginate(5);
		return ['areas' => $areas];
	}

	public function store(AreaRequest $request)
	{
		
		try {
			$id = $request->input('id');
			$Area = Area::firstOrNew(['id' => $id]);
			$Area->fill($request->all());
			$Area->save();

			return [
				'success' => true,
				'message' => ($id) ? 'Registro Actualizado' : 'Registro Exitoso'
			];
		} catch (\Throwable $th) {

			return [
                'success' => false,
                'message' => $th->getMessage()
            ];
		}	
	}

	public function destroy($id)
	{
        $record = Area::findOrFail($id);
        $record->update([
			'estado' => 0
		]);
		return [
            'success' => true,
            'message' => 'Eliminada con éxito'
		];
	}
}