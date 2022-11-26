<?php

namespace App\Http\Controllers;

use App\Models\TipoOrden;
use Illuminate\Http\Request;
use App\Http\Requests\TipoOrdenRequest;

class TipoOrdenController extends Controller
{
    public function index()
	{
		return view('tipodeorden.index');
	}

	public function records()
	{
		$tipoorden = TipoOrden::get();
		return ['tipoorden' => $tipoorden];
	}

	public function store(TipoOrdenRequest $request)
	{
		try {
			$id = $request->input('id');
			$Area = TipoOrden::firstOrNew(['id' => $id]);
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
        $record = TipoOrden::findOrFail($id);
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
        $person = TipoOrden::findOrFail($id);
		$person->update(['estado' => 1]);

		return [
			'success' => true,
			'message' => 'Tipo Orden Restaurado con exito'
		];
    }
}
