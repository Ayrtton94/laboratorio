<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Requests\ScheduleRequest;

class ScheduleController extends Controller
{

    public function index()
    {
        return view('schedule.index');
    }

	public function records()
	{
		$schedules = Schedule::get();
		return ['schedules' => $schedules];
	}

    public function store(ScheduleRequest $request)
    {
       try {
			$id = $request->input('id');
			$Schedule = Schedule::firstOrNew(['id' => $id]);
			$Schedule->fill($request->all());
			$Schedule->save();

			return [
				'success' => true,
				'message' => ($id) ? 'Registro Actualizado' : 'Registro Exitoso'
			];
		} catch (Throwable $th) {

			return [
                'success' => false,
                'message' => $th->getMessage()
            ];
		}	
    }

	public function restore($id)
    {
        $record = Schedule::findOrFail($id);
        $record->update([
			'status' => 1
		]);

        return [
            'success' => true,
            'message' => 'Resturado con éxito'
        ];
	}

    public function destroy($id)
    {
		
        $record = Schedule::findOrFail($id);
        $record->update([
			'status' => 0
		]);
		return [
            'success' => true,
            'message' => 'Eliminada con éxito'
		];
    }
}
