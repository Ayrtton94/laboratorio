@php
    $customer = $order->customer;
    $path_style = app_path('CoreDevPro'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.'style.css');
    $order_number = $order->series.'-'.str_pad($order->number, 8, '0', STR_PAD_LEFT);
    $establishment2 = Establishment::without('country', 'department', 'province', 'district','almacenes')->find($order->establishment_id);
	$usuario = User::without('identity_document_type', 'country', 'department', 'province', 'district')->find($order->user_id);
    $configuration = Configuration::first();
    $order_configuration = DocumentConfiguration::first();
@endphp
<html>
<head>
    <title>PEDIDO</title>
    <link href="{{ $path_style }}" rel="stylesheet"/>
    <style>
        html {
            font-family: sans-serif;
        }

        .color-primary {
            color: {{ $company->color_primary}}
        }

        .color-secondary {
            color: {{ $company->color_secondary}}
        }

        .border-primary {
            border: 1px solid{{ $company->color_primary}}
        }

        .border-top {
            border-top: 1px solid{{ $company->color_primary}}
        }
        
    </style>
</head>
<body>
@if($format =='ticket')
    @if($company->logo_ticket  ||$company->logo)
        <div class="text-center company_logo_box pt-4">
            <img src="{{ asset('storage/uploads/logos/'.($company->logo_ticket ??$company->logo) )}}"
                 class="company_logo_ticket contain">
        </div>
    @endif
    <table class="full-width">
        <tr>
            <td class="text-center"><h4>{{ $company->name }}</h4></td>
        </tr>
        <tr>
            <td class="text-center"><h5>{{ 'RUC '.$company->number }}</h5></td>
        </tr>
        <tr>
            @if($establishment->address !== '-')
                <td class="text-center"> {!!$establishment->address  !!}
                    <br>{{strtoupper($establishment->department->description) }}
                    , {{strtoupper($establishment->province->description) }}
                    , {{ strtoupper($establishment->district->description) }}</td>
            @endif
        </tr>
        <tr>
            <td class="text-center">{{ ($establishment->email !== '-')? $establishment->email : '' }}</td>
        </tr>
        <tr>
            <td class="text-center pb-3">{{ ($establishment->telephone !== '-')? $establishment->telephone : '' }}</td>
        </tr>
        <tr>
            <td class="text-center pt-3 border-top"><h4>{{ $order->document_type->description }}</h4></td>
        </tr>
        <tr>
            <td class="text-center pb-3 border-bottom"><h3>{{ $order_number }}</h3></td>
        </tr>
    </table>

@else
    <table class="full-width">
        <tr>
            <td class="text-center"><h4>{{ $company->name }}</h4></td>
        </tr>
        <tr>
            <td class="text-center"><h5>{{ 'RUC '.$company->number }}</h5></td>
        </tr>
        <tr>
            <td class="text-center pt-3 border-top"><h4>DESPACHO DE ORDEN {{ $order_number }} </h4></td>
        </tr>
    </table>
@endif
<table class="full-width">
    <tr>
        <td width="45%" class="pt-3"><p class="desc">Fecha de emisión:</p></td>
        <td width="" class="pt-3"><p
                class="desc">{{ $order->date_of_issue->format('Y-m-d') }} {{ $order->time_of_issue }}</p></td>
    </tr>

    @isset($invoice->date_of_due)
        <tr>
            <td><p class="desc">Fecha de vencimiento:</p></td>
            <td><p class="desc">{{ $invoice->date_of_due->format('Y-m-d') }}</p></td>
        </tr>
    @endisset

    <tr>
        <td class="align-top"><p class="desc">Cliente:</p></td>
        <td><p class="desc">{{ $customer->name }}</p></td>
    </tr>
    <tr>
        <td><p class="desc">{{ $customer->identity_document_type->description }}:</p></td>
        <td><p class="desc">{{ $customer->number }}</p></td>
    </tr>

    @if ($customer->address !== '')
        <tr>
            <td class="align-top"><p class="desc">Dirección:</p></td>
            <td><p class="desc">{{ $customer->address }}</p></td>
        </tr>
    @endif
    @if ($order_configuration->seller)
        <tr>
            <td class="align-top"><p class="desc">Vendedor:</p></td>
            @if($order->vendedor)
                <td colspan="2"><p class="desc">{{ strtoupper(optional($order->vendedor)->name) }}</p></td>
            @else
                @if($order->order)
                    <td colspan="2"><p class="desc">{{ strtoupper(optional(optional($order->order)->user)->name) }}</p>
                    </td>
                @else
                    <td colspan="2"><p class="desc">{{ strtoupper(optional($order->user)->name) }}</p></td>
                @endif

            @endif
        </tr>
    @endif

</table>
<table class="full-width mt-10 mb-10">
    <thead class="">
    <tr>
        <th class="border-top-bottom desc-9 text-left">CANT.</th>
        <th class="border-top-bottom desc-9 text-left">UNIDAD</th>
        <th class="border-top-bottom desc-9 text-left">DESCRIPCIÓN</th>
        @if($format =='ticket')
        <th class="border-top-bottom desc-9 text-left">P.UNIT</th>
        <th class="border-top-bottom desc-9 text-left">TOTAL</th>
        @endif
    </tr>
    </thead>
    <tbody>

    @foreach($order->items as $row)

        <tr>
            @php
                $decimal = 0;
				$itemFind = \App\Models\Item::find($row->item_id);
					$marca = '';
					if(optional($itemFind)->trademark_id)
					{
						$marcaModel = \App\Models\Trademarks::find($itemFind->trademark_id);
						if($marcaModel)
						{
							$marca = $marcaModel->name;
						}

					}
            @endphp
            @if (strlen(stristr($row->quantity, '.0000')) == 0)
                @php
                    $decimal = 2;
                @endphp
            @endif
            <td class="text-center desc-9 align-top">{{ number_format($row->quantity, $decimal) }}</td>
            <td class="text-center desc-9 align-top">
                @php
                    $unidad = \App\Models\Catalogs\UnitType::where('id',$row->unit_type_id)->first();
                    if($unidad) echo (empty($unidad->symbol) ? $row->unit_type_id :$unidad->symbol);
                    else echo $row->unit_type_id;
                @endphp
            </td>
            <td class="text-left desc-9 align-top">
                {!! $row->item->description !!}  -- {{ $marca }}
                @php
                    if(session('SHOW_PRESENTACION_DOCUMENTO')->valor==1)
                    {
                        $presentacion = \App\Models\UnidadEquivalente::where('id', $row->equivalencia_id)->without('tipoprecio','moneda','almacen','unidad_equivalente')->first();
                        if($presentacion) echo "<br><small>{$presentacion->descripcion}</small>";
                    }

                @endphp
                @if($row->attributes)
                    @foreach($row->attributes as $attr)
                        <br/>{!! $attr->description !!} : {{ $attr->value }}
                    @endforeach
                @endif
                @if($row->discounts)
                    @foreach($row->discounts as $dtos)
                        <br/><small>{{ $dtos->factor * 100 }}% {{$dtos->description }}</small>
                    @endforeach
                @endif
            </td>
            @if($format =='ticket')
            <td class="text-right desc-9 align-top">{{ number_format($row->unit_price, 2) }}</td>
            <td class="text-right desc-9 align-top">{{ number_format($row->total, 2) }}</td>
            @endif
        </tr>
        <tr>
            <td colspan="5" class="border-bottom"></td>
        </tr>
    @endforeach

    @if($format =='ticket')
        @if($order->total_exportation > 0)
            <tr>
                <td colspan="4" class="text-right font-bold desc">OP.
                    EXPORTACIÓN: {{ $order->currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($order->total_exportation, 2) }}</td>
            </tr>
        @endif
        @if($order->total_free > 0)
            <tr>
                <td colspan="4" class="text-right font-bold desc">OP.
                    GRATUITAS: {{ $order->currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($order->total_free, 2) }}</td>
            </tr>
        @endif
        @if($order->total_unaffected > 0)
            <tr>
                <td colspan="4" class="text-right font-bold desc">OP.
                    INAFECTAS: {{ $order->currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($order->total_unaffected, 2) }}</td>
            </tr>
        @endif
        @if($order->total_exonerated > 0)
            <tr>
                <td colspan="4" class="text-right font-bold desc">OP.
                    EXONERADAS: {{ $order->currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($order->total_exonerated, 2) }}</td>
            </tr>
        @endif
        @if($order->total_taxed > 0)
            <tr>
                <td colspan="4" class="text-right font-bold desc">OP. GRAVADAS: {{ $order->currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($order->total_taxed, 2) }}</td>
            </tr>
        @endif
        @if($order->total_discount > 0)
            <tr>
                <td colspan="5" class="text-right font-bold">DESCUENTO TOTAL: {{ $order->currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($order->total_discount, 2) }}</td>
            </tr>
        @endif

        <tr>
            <td colspan="4" class="text-right font-bold desc">IGV: {{ $order->currency_type->symbol }}</td>
            <td class="text-right font-bold desc">{{ number_format($order->total_igv, 2) }}</td>
        </tr>

        @if($order->total_plastic_bag_taxes > 0)
            <tr>
                <td colspan="4" class="text-right font-bold desc">ICBPER: {{ $order->currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($order->total_plastic_bag_taxes, 2) }}</td>
            </tr>
        @endif
        @if ($order->detraction)
            <tr>
                <td colspan="4" class="text-right font-bold desc">TOTAL DETRACCIÓN: S/</td>
                <td class="text-right font-bold desc"> {{ number_format($order->detraction->amount,2)}}</td>
            </tr>
        @endif
        <tr>
            <td colspan="4" class="text-right font-bold desc">TOTAL A PAGAR: {{ $order->currency_type->symbol }}</td>
            <td class="text-right font-bold desc">{{ number_format($order->total, 2) }}</td>
        </tr>
    @endif
    </tbody>
</table>

@if($format =='ticket')
    <table class="full-width">

        @foreach($order->legends as $row)
            <tr>
                @if ($row->code == 1000)
                    <td class="desc pt-3">Son: <span
                            class="font-bold">{{ $row->value }} {{ $order->currency_type->description }}</span></td>
                @else
                    <td class="desc pt-3"> {{$row->code}}: {{ $row->value }} </td>
                @endif
            </tr>
        @endforeach

        <tr>
            <td class="desc pt-3">
                <strong>Información adicional</strong>
                @foreach($order->additional_information as $information)
                    <p class="desc">{{ $information }}</p>
                @endforeach
            </td>
        </tr>
        @if(session()->has('MOSTRAR_PIE_PAGINA'))
            @if(session('MOSTRAR_PIE_PAGINA')->valor == 1)

                <tr>


                    @php

                        $est = \App\Models\Establishment::without('country', 'department', 'province', 'district')->find($order->establishment_id);
                        $pie_pagina = $est ? $est->pie_pagina : '';
                    @endphp

                    <td class="text-center desc">{!! $pie_pagina !!}</td>


                </tr>
            @endif
        @endif
    </table>
@endif
</body>
</html>
