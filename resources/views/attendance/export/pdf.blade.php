<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Reporte Asistencia</title>
        <style>
            .clearfix:after {
                content: "";
                display: table;
                clear: both;
            }

            body {
                color: #555555;
                background: #FFFFFF; 
                font-family: "Gill Sans Extrabold", Helvetica, sans-serif
                font-size: 12px;
            }

            #details {
                margin-bottom: 20px;
            }

            #client {
                padding-left: 6px;
                border-left: 6px solid #0087C3;
                float: left;
            }

            #client .to {
                color: #777777;
            }

            h2.name {
                font-size: 14px;
                font-weight: normal;
                margin: 0;
                padding-bottom: 6px;
            }

			h3.name {
                font-size: 10px;
                font-weight: normal;
                margin: 0;
                padding-bottom: 6px;
            }

            .date {
                font-size: 10px;
                color: #777777;
                margin: 0;
                padding-top: 4px;
            }
            h2.title_report{
                font-size: 20px;
            }

            table {
                width: 100%;
                font-size: 10px;
                border-collapse: collapse;
                border-spacing: 0;
            }

            table th,
            table td {
                padding: 2px;
                background: #EEEEEE;
                border-bottom: 1px solid #FFFFFF;
            }

            table th {
                white-space: nowrap;        
                font-weight: bold;
                font-size: 14px;
            }

            table td {
                text-align: right;
            }

            table td h3{
                color: #383a39;
                font-size: 1.2em;
                font-weight: normal;
                margin: 0 0 0.2em 0;
            }

            table .no {
                color: #FFFFFF;
                font-size: 12px;
                background: #7F2636;
                text-align: center;
            }

            table .desc {
                font-size: 11px;
                text-align: center;
            }
            table .desc_rander {
                background: #DDDDDD;
                font-size: 12px;
                text-align: left;
                color: #635d5d;
            }

            table .unit {
                background: #DDDDDD;
                text-align: center;
            }

            table .total {
                background: #7F2636;
                color: #FFFFFF;
                text-align: left;
                font-size: 12.5px;
            }

            table .total_title {
                background: #7F2636;
                color: #FFFFFF;
                text-align: center;
                font-size: 12.5px;
            }

            table td.unit,
            table td.total {
                font-size: 12px;
            }

            table .cliente_unit{
                font-size: 8px;
            }

            table tbody tr:last-child td {
                border: none;
            }

            table tfoot td {
                padding: 10px 20px;
                background: #FFFFFF;
                border-bottom: none;
                font-size: 1.2em;
                white-space: nowrap; 
                border-top: 1px solid #AAAAAA; 
            }

            table tfoot tr:first-child td {
                border-top: none; 
            }

            table tfoot tr:last-child td {
                color: #07C488;
                font-size: 1.4em;   
            }

            table tfoot tr td:first-child {
                border: none;
            }
        </style>
    </head>
    <body>
		<table>
			<tr>
				<td style="background: #FFF;" width="55%">
					<div id="details" class="clearfix">
						<div id="client">
							<h2 class="name"><strong>RUC:</strong>10743704121</h2>
						</div>
					</div>
				</td>
				<td style="background: #FFF;" width="10%">
					<img src="{{ asset('assets/images/logo_1.png') }}" class="company_logo" style="max-width: 150px">
				</td>
			</tr>
		</table>
		<main>
            <div id="details" class="clearfix">
                <div id="client">
                    <h2 class="name"><strong>{{ optional($staff)['name'].' '.optional($staff)['ap_lastname'].' '.optional($staff)['am_lastname'] }}</strong></h2>
					<h3 class="name"><strong>{{ optional($staff)['address'] }}</strong></h3>
                    <div class="date"><strong>FECHA:</strong> {{date('Y-m-d')}}</div>
                </div>
            </div>
            @if(!empty($records))
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th class="total">Fecha</th>
						<th class="total_title">H. Asistidas</th>
                        <th class="total_title">H. No Asistidas</th>
                        <th class="total_title">Retardos Min</th>
                        <th class="total_title">Salidas Tempranas Min</th>
                        <th class="total_title">H. Extras</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($records as $row)
                        <tr>
							<td class="desc_rander">{{ $row['date_of_issue'] }}</td>
							<td class="no">{{ $row['hours_attended'] }}</td>
							<td class="desc"></td>
							<td class="no">{{ $row['delays_min'] }}</td>
							<td class="desc">{{ $row['ouput_min'] }}</td>
							<td class="no">{{ $row['extra_hours'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="callout callout-info">
                    <p>No se encontraron registros.</p>
                </div>
            @endif
        </main>
    </body>
</html>