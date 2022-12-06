<?php

namespace App\Http\Resources;

use DateTime;
use App\Models\Person;
use App\Models\Schedule;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AttendanceCollection extends ResourceCollection
{
    
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key){
			return [
				'id' => $row->id,
				'name_staff' => self::getPerson($row->staff_id),
				'address' => self::getAddress($row->staff_id),
				'date_of_issue' => $row->date_of_issue,
				'hours_attended' => self::restarHoras($row),
				'delays_min' => self::getDelay($row),
				'ouput_min' => self::getOuput($row),
				'schedule_hours' => self::getSchedule($row),
				'extra_hours' => self::getExtraHours($row),
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

	public static function getAddress($row)
	{
		$string = '';
		$persons = Person::where('type', 'staff')->where('id', $row)->first();
		return $string .= optional($persons)->address;
	}

	public static function restarHoras($row)
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

	#Horario del trabajador
	public static function getSchedule($row)
	{
		$schedule = Schedule::where('id', $row->schedule_id)->first();
		$horaInicio = new DateTime($schedule->hour_start);
		$horaTermino = new DateTime($schedule->hour_end);
		$scheduleHour = $horaInicio->diff($horaTermino);
		$scheduleResult = $scheduleHour->format('%H:%I');

		return $scheduleResult;
	}

	public static function getDelay($row)
	{
		$valHoraInicio = !!$row->hour_start ? $row->hour_start : '00:00:00';
		$schedule = Schedule::where('id', $row->schedule_id)->first();
		$hourStart = new DateTime($schedule->hour_start);
		
		if(!!$valHoraInicio)
		{
			$horaInicio = new DateTime($valHoraInicio);
			$interval = $valHoraInicio>$schedule->hour_start ? $hourStart->diff($horaInicio) : '00:00:00';
			$hours_delay = optional($interval)->format('%H:%I');
			return $hours_delay;
		}
	}

	public static function getOuput($row)
	{
		$valHoraFinal = !!$row->hour_end ? $row->hour_end : '00:00:00';
		$schedule = Schedule::where('id', $row->schedule_id)->first();
		$hourEnd = new DateTime($schedule->hour_end);
		
		if(!!$valHoraFinal)
		{

			$horaFinal = new DateTime($valHoraFinal);
			
			$interval = $valHoraFinal<$schedule->hour_end ? $hourEnd->diff($horaFinal) : '00:00:00';
			
			$hours_delay = $valHoraFinal!='00:00:00' ? optional($interval)->format('%H:%I') : '00:00';
			return $hours_delay;
		}
	}

	public static function getExtraHours($row)
	{
		$restarHoras = self::restarHoras($row);
		$getSchedule = self::getSchedule($row);

		$horaInicioH1 = new DateTime($restarHoras);
		$horaTerminoH2 = new DateTime($getSchedule);
		$scheduleHour = $horaInicioH1->diff($horaTerminoH2);

		$scheduleResult = $restarHoras>$getSchedule ? $scheduleHour->format('%H:%I') : '00:00';
		return $scheduleResult;
	}
}