<?php

namespace App\Http\Resources;

use DateTime;
use App\Models\Person;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AttendanceCollection extends ResourceCollection
{
    
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key){
			return [
				'id' => $row->id,
				'name_staff' => self::getPerson($row->staff_id),
				'date_of_issue' => $row->date_of_issue,
				'hours_attended' => self::restasHoras($row),
				'delays_min' => $row->delays_min,
				'ouput_min' => $row->ouput_min,
				'extra_hours' => $row->extra_hours,
				'justification_hours_cg' => $row->justification_hours_cg,
				'justification_hours_sg' => $row->justification_hours_sg,
				'comp_hours' => $row->comp_hours
			];
		});
    }

	public static function getPerson($row)
	{
		$string = '';
		$persons = Person::where('type', 'staff')->where('id', $row)->first();
		return $string .= optional($persons)->name .' ' . optional($persons)->ap_lastname .' ' . optional($persons)->am_lastname;
	}

	public static function restasHoras($row)
	{
		$valHoraInicio = !!$row->hour_start ? $row->hour_start : '00:00:00';
		$valHoraFinal = !!$row->hour_end ? $row->hour_end : '00:00:00';

		$valHoraInicio1 = !!$row->hour_start_1 ? $row->hour_start_1 : '00:00:00';
		$valHoraFinal1 = !!$row->hour_end_2 ? $row->hour_end_2 : '00:00:00';

		if(!!$valHoraInicio && !!$valHoraInicio && !!$valHoraInicio1 && !!$valHoraFinal1)
		{
			$horaInicio = new DateTime($valHoraInicio);
			$horaTermino = new DateTime($valHoraFinal);
			$horaInicio1 = new DateTime($valHoraInicio1);
			$horaTermino1 = new DateTime($valHoraFinal1);
			
			if($valHoraFinal!='00:00:00' || $valHoraFinal1!='00:00:00'){
				$interval = $valHoraFinal!='00:00:00' ? $horaInicio->diff($horaTermino) : ($valHoraFinal1!='00:00:00' ? $horaInicio1->diff($horaTermino1) : '00:00:00');
				
				$hours_attended = $interval->format('%H:%I');
				return $hours_attended;
			}
		}
	}
}