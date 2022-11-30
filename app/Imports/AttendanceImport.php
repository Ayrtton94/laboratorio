<?php

namespace App\Imports;

use App\Models\Person;
use App\Models\Attendance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;

class AttendanceImport implements ToCollection
{
	use Importable;
    protected $data;

	public function transformDate($value, $format = 'Y-m-d')
	{
		try {
			return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
		} catch (\Throwable $th) {
			return \Carbon\Carbon::createFromFormat($format, $value);
		}
	}

	public function transformTime($value, $format = 'H:i:s')
	{
		try {
			return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
		} catch (\Throwable $th) {
			return \Carbon\Carbon::createFromFormat($format, $value);
		}
	}

    public function collection(Collection $rows)
    {
		$total = count($rows);
		$type = request()->input('type');
		$registered = 0;
		unset($rows[0]);
		foreach ($rows as $row){
			
			if($row[0] != "")
			{
				// dd($row);
				$num_document = $row[0];
				$date_of_issue = $this->transformDate($row[3]);
				$hour_start = isset($row[4]) ? $this->transformTime($row[4]) : $row[4];
				$hour_end = isset($row[5]) ? $this->transformTime($row[5]) : $row[5];
				$hour_start_1 = isset($row[6]) ? $this->transformTime($row[6]) : $row[6];
				$hour_end_2 = isset($row[7]) ? $this->transformTime($row[7]) : $row[7];
				$delays_min = $row[8];
				$ouput_min = $row[9];
				
				$staff = Person::where('type', $type)->where('number', $num_document)->first();
				if(!!$staff){
					
					Attendance::create([
						'staff_id' => $staff->id,
						'date_of_issue' => $date_of_issue,
						'hour_start' => $hour_start,
						'hour_end' => $hour_end,
						'hour_start_1' => $hour_start_1,
						'hour_end_2' => $hour_end_2,
						'delays_min' => $delays_min,
						'ouput_min' => $ouput_min,
					]);
					$registered += 1;
				}
			}
        }
        $this->data = compact('total', 'registered');
    }

	public function getData(){
		return $this->data;
	}
}
