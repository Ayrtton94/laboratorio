@php
    // dd($order->order);
    use App\Models\Tenant\Catalogs\UnitType;use App\Models\Tenant\Configuration;use App\Models\Tenant\DocumentConfiguration;use App\Models\Tenant\Establishment;use App\Models\Tenant\UnidadEquivalente;use App\Models\Tenant\User;$establishment = $order->establishment;
    $customer = $order->customer;
    // $invoice = $document->invoice;
    $path_style = app_path('CoreDevPro'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.'style.css');
    $document_number = $order->series.'-'.str_pad($order->number, 8, '0', STR_PAD_LEFT);

    $establishment2 = Establishment::without('country', 'department', 'province', 'district','almacenes')->find($order->establishment_id);
    // $customer2 = \App\Models\Tenant\Person::without('identity_document_type', 'country', 'department', 'province', 'district')->find($document->customer_id);

	$usuario = User::without('identity_document_type', 'country', 'department', 'province', 'district')->find($order->user_id);

    // $payments = \App\Models\Tenant\Payment::where('table_id',$document->id)->with('payment_method')->where('table_name','documents')->get();

    $configuration = Configuration::first();
    $document_configuration = DocumentConfiguration::first();
    // $note = \App\Models\Tenant\Note::ByDocumentId($document->id)->first();
@endphp
<html>
<head>
    {{-- <title>{{ $document_number }}</title> --}}
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
<table class="full-width">
    <tr>
        @if($company->logo)
            <td width="20%">
                <div class="company_logo_box">
                    <img src="{{ asset('storage/uploads/logos/'.$company->logo) }}" alt="{{ $company->name }}"
                         class="company_logo" style="max-width: 150px;">
                </div>
            </td>
        @else
            <td width="20%">
                <img src="{{ asset('logo/logo.jpg') }}" class="company_logo" style="max-width: 150px">
            </td>
        @endif
        <td width="45%" class="pl-3">
            <div class="text-left">
                <h3 class="color-primary" style="text-align: center;"><strong>{{ $company->name }}</strong></h3>
                <h5>{{ $establishment2->description }}</h5>
                <h6>{{ strtoupper($establishment2->getAddressFullAttribute()) }}</h6>
                {{-- <h6>Telf: {{ ($establishment2->telephone !== '-')? $establishment2->telephone : '' }}</h6> --}}
                {{-- <h6>Email: {{ ($establishment2->email !== '-')? $establishment2->email : '' }}</h6> --}}
            </div>
        </td>
        <td width="35%" class="border-box py-4 px-1 text-center">
            <h3 class="text-center">{{ 'R.U.C. N° '.$company->number }}</h3>
            {{-- <h4 class="text-center">{{ $document->document_type->description }}</h4> --}}
            <h3 class="text-center color-secondary"><strong>N° {{ $document_number }}</strong></h3>
        </td>
    </tr>
</table>
<br>
<div class="border-no-bottom py-2 px-1 pb-0 border-primary">
    <table class="full-width mt-3 ">
        <tr>
            <td width="15%">Cliente:</td>
            <td width="45%">{{ $customer->name }}</td>
            <td width="25%">Fecha de emisión:</td>
            <td width="15%">{{ $order->date_of_issue->format('d/m/Y') }} </td>
        </tr>
        <tr>
            @if($order->customer_id != 1)
                <td width="15%">{{ $customer->identity_document_type->description }}:</td>
                <td width="45%">{{ $customer->number }}</td>
            @endif
            <td width="25%">Hora emisión:</td>
            <td width="15%">{{ $order->time_of_issue}} </td>

        </tr>
        @if($order->customer_id != 1)
            @if ($customer->address !== '')
                <tr>
                    <td class="align-top">Dirección:</td>
                    <td>{{ $customer->address  }}</td>
                </tr>
            @endif
        @endif

        @if ($document_configuration->seller)

            <tr>
                <td class="align-top"><p class="desc">Vendedor:</p></td>

                @if($order->vendedor)
                    @php
                        dd($order->vendedor)
                    @endphp
                    <td colspan="2"><p class="desc">{{ strtoupper(optional($order->vendedor)->name) }}</p></td>
                @else
                    @if($order->order)

                        <td colspan="2"><p
                                class="desc">{{ strtoupper(optional(optional($order->order)->user)->name) }}</p></td>

                    @else
                        <td colspan="2"><p class="desc">{{ strtoupper(optional($order->user)->name) }}</p></td>
                    @endif

                @endif
            </tr>

        @endif

    </table>

</div>
<div class="border-no-top py-4 px-1 border-primary">
    <table class="full-width mt-12 mb-10">
        <thead>
        <tr class="bg-grey">
            <th class="border-top text-left py-1">ITEM</th>
            <th class="border-top text-left py-1">COD.</th>
            <th class="border-top text-left py-2">DESCRIPCIÓN</th>
            <th class="border-top text-center py-1">CANT.</th>
            <th class="border-top text-center py-2">UNIDAD</th>
            <th class="border-top text-right py-2">P.UNIT</th>
            <th class="border-top text-right py-2">TOTAL</th>

        </tr>
        </thead>
        <tbody>
        @php $i = 1 @endphp
        @foreach($order->items as $row)
		@php
			$itemFind = \App\Models\Tenant\Item::find($row->item_id);
				$marca = '';
				if(optional($itemFind)->trademark_id)
				{
					$marcaModel = \App\Models\Tenant\Trademarks::find($itemFind->trademark_id);
					if($marcaModel)
					{
						$marca = $marcaModel->name;
					}

				}
		@endphp
            <tr>
                <td class="celda">{{ $i }}</td>
                <td class="celda">{{ $row->item->internal_id }}</td>
                <td class="celda">
                    {!! $row->item->description !!}  -- {{ $marca }}

                    @php
                            if(session('SHOW_PRESENTACION_DOCUMENTO')->valor==1)
                            {
                                $presentacion = UnidadEquivalente::where('id', $row->equivalencia_id)->without('tipoprecio','moneda','almacen','unidad_equivalente')->first();
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
                @php
                    $decimal = 0;
                @endphp
                @if (strlen(stristr($row->quantity, '.00')) == 0)
                    @php
                        $decimal = 2;
                    @endphp
                @endif
                <td class="celda text-center">{{ number_format($row->quantity, $decimal) }}</td>
                <td class="celda text-center">
                    @php
                        $unidad = UnitType::where('id',$row->unit_type_id)->first();
                        if($unidad) echo (empty($unidad->symbol) ? $row->unit_type_id :$unidad->symbol);
                        else echo $row->unit_type_id;
                    @endphp
                </td>
                <td class="celda text-right">{{ number_format($row->unit_price, $configuration->decimal) }}</td>
                <td class="celda text-right">{{ number_format($row->total, 2) }}</td>

            </tr>
            @php $i++ @endphp
        @endforeach
        </tbody>
    </table>

</div>
<br>
<div class="py-2 px-1">
    <table class="full-width">
        <tr>
            <td class="text-left" width="40%">
                @foreach($order->legends as $row)
                    <p>Son: <span class="font-bold">{{ $row->value }} {{ $order->currency_type->description }}</span>
                    </p>
                @endforeach
            </td>
            <td rowspan="2" width="12%" class="text-right">
                <table>
                    <tbody>
                    @if($order->total_exportation > 0)
                        <tr>
                            <td colspan="5" class="text-right font-bold">OP.
                                EXPORTACIÓN: {{ $order->currency_type->symbol }}</td>
                            <td class="text-right font-bold">{{ number_format($order->total_exportation, 2) }}</td>
                        </tr>
                    @endif
                    @if($order->total_free > 0)
                        <tr>
                            <td colspan="5" class="text-right font-bold">OP.
                                GRATUITAS: {{ $order->currency_type->symbol }}</td>
                            <td class="text-right font-bold">{{ number_format($order->total_free, 2) }}</td>
                        </tr>
                    @endif
                    @if($order->total_unaffected > 0)
                        <tr>
                            <td colspan="5" class="text-right font-bold">OP.
                                INAFECTAS: {{ $order->currency_type->symbol }}</td>
                            <td class="text-right font-bold">{{ number_format($order->total_unaffected, 2) }}</td>
                        </tr>
                    @endif
                    @if($order->total_exonerated > 0)
                        <tr>
                            <td colspan="5" class="text-right font-bold">OP.
                                EXONERADAS: {{ $order->currency_type->symbol }}</td>
                            <td class="text-right font-bold">{{ number_format($order->total_exonerated, 2) }}</td>
                        </tr>
                    @endif
                    @if($order->total_taxed > 0)
                        <tr>
                            <td colspan="5" class="text-right font-bold">OP.
                                GRAVADAS: {{ $order->currency_type->symbol }}</td>
                            <td class="text-right font-bold">{{ number_format($order->total_taxed, 2) }}</td>
                        </tr>
                    @endif
                    @if($order->total_discount > 0)
                        <tr>
                            <td colspan="5" class="text-right font-bold">DESCUENTO
                                TOTAL: {{ $order->currency_type->symbol }}</td>
                            <td class="text-right font-bold">{{ number_format($order->total_discount, 2) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="5" class="text-right font-bold">IGV: {{ $order->currency_type->symbol }}</td>
                        <td class="text-right font-bold">{{ number_format($order->total_igv, 2) }}</td>
                    </tr>
                    @if($order->total_plastic_bag_taxes > 0)
                        <tr>
                            <td colspan="5" class="text-right font-bold">
                                ICBPER: {{ $order->currency_type->symbol }}</td>
                            <td class="text-right font-bold">{{ number_format($order->total_plastic_bag_taxes, 2) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="5" class="text-right font-bold">TOTAL: {{ $order->currency_type->symbol }}</td>
                        <td class="text-right font-bold">{{ number_format($order->total, 2) }}</td>
                    </tr>

                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
