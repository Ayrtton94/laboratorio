<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Imports\AttendanceImport;
use App\Http\Resources\AttendanceCollection;

class AttendanceController extends Controller
{
	
    public function index()
    {
        return view('attendance.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

	public function records(Request $request)
	{
		$records = Attendance::with('persons')->get();
		
		return new AttendanceCollection($records);
		// return response()->json(['attendance' => $records]);
	}

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

	public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
				
                $import = new AttendanceImport();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                return [
                    'success' => true,
					'message' => 'Datos actualizados',
                    'data' => $data
                ];

            } catch (Throwable $th) {
                return [
                    'success' => false,
                    'message' => $th->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' => __('app.actions.upload.error'),
        ];
    }
}