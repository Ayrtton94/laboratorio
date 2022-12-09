<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromView, ShouldAutoSize, WithStyles
{
    use Exportable;
	
	public function styles(Worksheet $sheet)
    {
        $highestColumn = $sheet->getHighestColumn();
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->mergeCells("A1:G1")->getStyle('A1')->getAlignment()->setHorizontal('center');
        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
	
	public function excel_view($excel_view = 'attendance.export.excel')
	{
        $this->excel_view = $excel_view;        
        return $this;
    }

	public function records($records)
	{
        $this->records = $records;
        return $this;
    }

	public function staff($staff)
	{
        $this->staff = $staff;
        return $this;
    } 

	
    public function view(): View
	{
        return view($this->excel_view, [
            'records'=> $this->records,
			'staff'=>$this->staff  ?? null
        ]);
    }
}