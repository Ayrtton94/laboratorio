@php
    use App\Models\Catalogs\UnitType;
	use App\Models\Establishment;
	use App\Models\UnidadEquivalente;
	use App\Models\User;

	$establishment =  $establishment;
    $customer = $order->customer;
	$path_style = app_path('PdfStyle'.DIRECTORY_SEPARATOR.'style.css');
    $document_number = $order->series.'-'.str_pad($order->number, 8, '0', STR_PAD_LEFT);
    $establishment2 = Establishment::without('country', 'department', 'province', 'district')->find($order->establishment_id);
	$usuario = User::without('country', 'department', 'province', 'district')->find(1);
@endphp
<html>
<head>
    <title>PEDIDO</title>
    <link href="{{ $path_style }}" rel="stylesheet"/>
	<style>
		h6{
			 font-size: 14px !important;
			 margin: 0 !important;
			 padding: 0 !important;

			font-weight: 300 !important;
    		letter-spacing: normal !important;
    		line-height: 15px;
		}
		table, tr, td, th {
			font-size: 13px !important;
		}
	</style>
</head>
<body>
<div class="container">
    <div class="row">
        <img class="img-fluid" style="height:47px" src="{{ asset('assets/images/logo_1.png') }}">
        <table>
            <tbody>
            <tr>
                <td style="width: 545px;">Fecha:  {{ $order->date_of_issue }}</td>
                <td style="width: 300px;">Orden N°:  {{ $document_number }}</td>
            </tr>
            </tbody>
        </table>
    </div>
	<hr>
    <div class="row">
        <table>
            <tbody>
            <tr>
                <td colspan="2">DATOS GENERALES</td>
                <hr>
            </tr>
            <tr>
                <td style="width: 400px;">Razón Social: {{ $company->name }}</td>
                <td style="width: 400px;">Teléfono: {{ $company->telephone }}</td>
            </tr>
            <tr>
                <td style="width: 400px;">Ruc: {{ $company->number }}</td>
                <td style="width: 400px;">Celular: {{ $company->phone }}</td>
            </tr>
            <tr>
                <td colspan="2">Dirección: {{ $company->address }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <hr>
	<div class="row">
        <table>
            <tbody>
            <tr>
                
                <td colspan="2">DATOS DEL CLIENTE</td>
                <hr>
            </tr>
            <tr>
                <td style="width: 400px;">Solicitante: {{ $order->person->name}}</td>
                <td style="width: 400px;">N° Documento: {{ $order->person->number}}</td>
            </tr>
            <tr>
                <td style="width: 400px;">Atención: {{ $order->staff->name}}</td>
                <td style="width: 400px;">N° Contacto: {{ $order->staff->telephone}}</td>
            </tr>
            <tr>
                <td style="width: 400px; text-transform: capitalize !important;">Dirección: {{ $order->person->address}}</td>
                <td style="width: 400px;">Email: {{ $order->person->email}}</td>
            </tr>
           
            </tbody>
        </table>
    </div>
		<br>
        <h6>En atención a su solicitud ponemos a consideración la presente propuesta económica para los ensayos solicitados:</h6>
		<br>
	<div class="border-no-top py-4 px-1 border-primary">
        <table class="full-width mt-12 mb-10" cellspacing="0" cellpadding="0">
            <thead >
            <tr>
                <td style="border-bottom: 1pt solid #b2b2b2;">Muestra</td>
                <td style="border-bottom: 1pt solid #b2b2b2;">Ensayo</td>
                <td style="border-bottom: 1pt solid #b2b2b2;">N° Referencia</td>
                <td style="border-bottom: 1pt solid #b2b2b2;">Laboratorio</td>
                <td style="border-bottom: 1pt solid #b2b2b2;">Cant</td>
                <td style="border-bottom: 1pt solid #b2b2b2;">Unitario</td>
                <td style="border-bottom: 1pt solid #b2b2b2;">Total</td>
            </tr>
            
            </thead>
            <tbody>
				@foreach($order->items as $row)
					<tr>
						<td>{{ $row->muestra->description }}</td>
						<td>{{ $row->ensayo->name }}</td>
						<td>{{ $row->observacion }}</td>
						<td>{{ $row->ensayo->laboratorio->name }}</td>
						<td>{{ number_format($row->quantity,2) }}</td>
						<td>{{ number_format($row->unit_price, 2) }}</td>
						<td>{{ $row->total }}</td>
					</tr>
				@endforeach
                <tr>
                	<td colspan="3"></td>
                	<td colspan="3"  style="border-top: 1pt solid #b2b2b2;"><strong>T. Pagar (Incluye IGV):</strong></td>
                	<td  style="border-top: 1pt solid #b2b2b2;"><strong>{{ $order->total }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    
	<div class="row">
    <table>
            <tbody >
                <tr>
                    <td colspan="2" style="text-align: justify;">OBSERVACIONES</td>
                    <hr>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: justify;">
                        <h6>
                        1. Para el caso de cotizaciones enviadas via email o whatsapp, se considera la recepción 
                        del servicio con el envío de la orden de servicio o de compra respectiva.
                        </h6>
                    </td>
                </tr>
				<br>
                <tr>
                    <td colspan="2" style="text-align: justify;">
                        <h6>
                        2. Para el caso de cotizaciones solicitadas verbalmente o entregadas físicamente, se considera
                        la aceptación del servicio previa firma del cliente adjuntando nombre completo y número de DNI. De ser el Solicitante
                        una persona jurídica, la cotización firmada será enviada al email de la organización  solicitante.
                        </h6>
                    </td>
                </tr>
				<br>
                <tr>
                    <td colspan="2" style="text-align: justify;">
                        <h6>
                        3. La cotización constituye un acuerdo entre el CLIENTE y LABVETSUR, por lo tanto cualquier discrepancia con 
                        el servicio se realiza en base al contenido de la misma (incluido anexo-consideraciones del servicio solicitado y del ADENDUM utilizado
                        de manera excepcional) y no de otro documento. Se entiende que, una vez aceptada por parte del CLIENTE, este acepta el contenido
                         y consideraciones de la misma, tal como Razón Social, RUC, Dirección, entre otros.
                        </h6>
                    </td>
                </tr>
				<br>
                <tr>
                    <td colspan="2" style="text-align: justify;">
                        <h6>
                        4. Si el cliente lo solicita se puede generar un contrato por la prestación del servicio.
                        </h6>
                    </td>
                </tr>
				<br>
                <tr>
                    <td colspan="2" style="text-align: justify;">
                        <h6>
                        5. Para coordinar día y hora de la recepción de la muestra, así como cualquier recomendación respecto a la 
                        cantidad, recolección y conservación de las muestras, por favor comuníquese con anticipación a nuestros canales de contacto.
                        </h6>
                    </td>
                </tr>
				<br>
                <tr>
                    <td colspan="2" style="text-align: justify;">
                        <h6>
                        6. Para el inicio del servicio, cancelar el 100% al ingreso de la muestra a la cuenta 215-1300681-0-08 Banco de Crédito del Perú 
                        (CCI: xxxx), Cta. Detracciones. B. Nación: 00-101-213250.
                        </h6>
                    </td>
                </tr>
				<br>
                <tr>
                    <td colspan="2" style="text-align: justify;">
                        <h6>
                        7. Horario de atención de Lunes a Viernes: 8:30 am - 5:15 pm y Sábados: 09:00 am - 12:00pm.
                        </h6>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row" style="margin-top: 100px">
        <table>
            <tbody>
            <tr>
                <td style="width: 500px;" style="text-align: center;">
                    ___________________________________
                    <br>
                    MVZ. Jorge E. Manrique Meza
                    <br>
                    Gerente General
                    <br>
                    LABVETSUR
                </td>
                <td style="width: 150px;">
                   
                </td>
                <td style="width: 500px;" style="text-align: center;">
                    ___________________________________
                    <br>
                    Cliente
                    <br>
                    Nombre ___________________________
                    <br>
                    DNI _______________________________
                </td>
            </tr>
            </tbody>
        </table>        
    </div>
    <hr>
    <div class="row">
    <table>
            <tbody >
                <tr>
                    <td colspan="2" style="text-align: justify;">ANEXOS</td>
                    <hr>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: justify;">
                        1. LABVETSUR oferta ensayos de laboratorio a personas naturaios y juridicas.
                    </td>
                </tr>
				<br>
                <tr>
                    <td colspan="2" style="text-align: justify;">
                        2. LABVETSUR cuenta con personal y equipamiento confome a los requisitos de la norma NTP ISO/EC 17025:2017.
                    </td>
                </tr>
				<br>
                <tr>
                    <td colspan="2" style="text-align: justify;">
                        3. El cliente se compromete a brindar la informacion aportuna y veraz sobre la muestra, por lo tanto no asumira las consecuencias 
                        legales y econamicas derivadas de una información errónea proporcionada por el cliente.
                    </td>
                </tr>
				<br>
                <tr>
                    <td colspan="2" style="text-align: justify;">
                        4. Los resultados obtenidos a partir de los ensayos realzados son emitidos en el documento denominado "Informe de Ensayo*.
                    </td>
                </tr>
				<br>
                <tr>
                    <td colspan="2" style="text-align: justify;">
                        5. Todas las muestras (no perecibles) seran conservadas hasta la entrega del informe de ensayo al cliente.
                    </td>
                </tr>
				<br>
                <tr>
                    <td colspan="2" style="text-align: justify;">
                        6. Es responsabilidad del laboratorio la disposicion final de las muestras salvo que el usuario solicite expresamente la devolución de éstas, 
                        lo cual quedará debidamente señalado en el campo otros de la presente cotizacion.
                       
                    </td>
                </tr>
				<br>
                <tr>
                    <td colspan="2" style="text-align: justify;">
                        7. Cualquier insatisfacción o queja por los servicios realizados, podrá ser dirigida a labvetsur@hotmail.com, cuyo plazo de respuesta sera no mayor a 03 días hábiles, donde se declara la admisibilidad o no de la queja. El plazo final para la atencion de los reclamos o insatisfacciones no sera mayor a 30 dias hábiles. 
                        Una vez ingresada la insatisfaccion o la queja se el enviara el flujograma de quejas - LABVETSUR.
                        
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>