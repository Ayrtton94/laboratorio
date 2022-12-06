<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\AttendanceExport;
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
		$records = Attendance::with('persons');
		if(!!$request->staff_id && !!$request->date_of_issue_1 && $request->date_of_issue_2){
			$records->where('staff_id', $request->staff_id);
			$records->whereBetween('date_of_issue', [$request->date_of_issue_1,$request->date_of_issue_2]);
		}
		
		return new AttendanceCollection($records->paginate(env('ITEMS_PER_PAGE', request('per_page'))));
	}

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
		$Attendance = Attendance::where('id', $request->input('id'))->first();
		
		if($Attendance){
			$Attendance->update([
				'justification_hours_cg' => $request->input('justification_hours_cg'),
				'justification_hours_sg' => $request->input('justification_hours_sg'),
				'comp_hours' => $request->input('comp_hours')
			]);
		}
		return [
            'success' => true,
            'message' => 'Datos Actualizados'
        ];
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

	public function pdf(Request $request)
	{
		$type = 'pdf';
		$records = $this->getExport($type, $request->date_of_issue_1, $request->date_of_issue_2, $request->staff_id);
		return $records;
    }
	
	public function excel(Request $request)
	{
		$type = 'excel';
		$records = $this->getExport($type, $request->date_of_issue_1, $request->date_of_issue_2, $request->staff_id);
		return $records;
    }

	public function getExport($type,$date_one, $date_two, $staff_id)
	{
		
		$records = Attendance::with('persons')
					->whereBetween('date_of_issue', [$date_one,$date_two])
					->where('staff_id', $staff_id)->get();

		$staff = Person::where('type', 'staff')->find($staff_id);

		$records = collect(new AttendanceCollection($records));

		if($type=='pdf') {
			set_time_limit(300);
			$pdf = Pdf::loadView('attendance.export.pdf',compact("staff","records"))->setPaper('a4', 'portrait');
			return $pdf->stream();
		}else{
			return (new AttendanceExport)->excel_view('attendance.export.excel')->records($records)->staff($staff)->download('ReportAsistencia'.Carbon::now().'.xlsx');
		}
	}
}