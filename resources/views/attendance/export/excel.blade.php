<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Reporte</title>
    </head>
    <body>
		<div>
            <p align="center" class="title"><strong>REPORTE ASISTENCIA</strong></p>
        </div>
        <div style="margin-top:20px; margin-bottom:15px;">
            <table>
                <tr>
                    <td>
                        <p><b>Empresa: </b></p>
                    </td>
                    <td align="center">
                        <p><strong>LABVETSUR</strong></p>
                    </td>
                    <td>
                        <p><strong>FECHA: </strong></p>
                    </td>
                    <td align="center">
                        <p><strong>{{date('Y-m-d')}}</strong></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Ruc: </strong></p>
                    </td>
                    <td align="center">10743704121</td>
                    <td>
                        <p><strong>Establecimiento: </strong></p>
                    </td>
                    <td align="center">Oficina Principal</td>
                </tr>
				<tr>
                    <td colspan="3">
                        <p><strong>Trabajador: &nbsp;&nbsp; </strong>{{ optional($staff)['name'].' '.optional($staff)['ap_lastname'].' '.optional($staff)['am_lastname'] }}</p>
                    </td>

					<td colspan="3">
                        <p><strong>Dirección: &nbsp;&nbsp; </strong> {{ optional($staff)['address'] }}</p>
                    </td>
                </tr>
            </table>
			
        </div>
        <br>
        @if(!empty($records))
			<table>
				<thead>
					<tr>
						<th style="background: forestgreen; color: white; font-weight: bold; width: 12px; height: 22px;">Fecha</th>
                        <th style="background: forestgreen; color: white; font-weight: bold; width: 40px;">H. Asistidas</th>
                       	<th style="background: forestgreen; color: white; font-weight: bold; width: 40px;">H. No Asistidas</th>
						<th style="background: forestgreen; color: white; font-weight: bold; width: 40px;">Retardos Min</th>
						<th style="background: forestgreen; color: white; font-weight: bold; width: 40px;">Salidas Tempranas Min</th>
						<th style="background: forestgreen; color: white; font-weight: bold; width: 40px;">H. Extras</th>
					</tr>
				</thead>
				<tbody>
					@foreach($records as $key => $row)
						<tr>
							<td>{{ $row['date_of_issue'] }}</td>
							<td>{{ $row['hours_attended'] }}</td>
							<td></td>
							<td>{{ $row['delays_min'] }}</td>
							<td>{{ $row['ouput_min'] }}</td>
							<td>{{ $row['extra_hours'] }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
        @else
            <div>
                <p>No se encontraron registros.</p>
            </div>
        @endif
    </body>
</html>