<?php

    namespace App\Http\Controllers;

    use Barryvdh\DomPDF\Facade as PDF;
    use Mpdf\Mpdf;
    use Nexmo\Account\Price;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use App\Models\LaboratorioOrder;

class LaboratorioOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('input.request:order,web', ['only' => ['store', 'update']]);
    }

    public function index()
    {
       return view('orders.index');
    }

    public function columns()
    {
        return [
            'number' => 'Número / Serie-Número',
			'date_of_issue' => 'Fecha de emisión',
			'nombre_cliente' => 'Nombre Identificador',
			'customer_id' => 'Nombre / Razón Social',
			'customer_number' => 'Documento Cliente',
			'user_id' => 'Usuario',
        ];
    }

	public function recordsAll()
    {
		$idOrder = request('order_id')==1 ? 1 : (request('order_id')==2 ? 2 : (request('order_id')==3 ? 0 : null));
		$records = LaboratorioOrder::without('state_type', 'document_type', 'currency_type', 'group', 'items')
		->with('user','document_type','state_type')->where('estado', $idOrder)
		->whereBetween('date_of_issue', [request('fecha_inicio'), request('fecha_fin')]);
		if(! auth()->user()->hasRole('administrador'))
		{
			$records = $records->where('establishment_id',auth()->user()->establishment_id);
		}
        return new OrderCollection($records->paginate(env('ITEMS_PER_PAGE', request('per_page'))));
    }

	public function AllOrder()
    {
		$busqueda = request('search');
		$idOrder = request('order_id')==1 ? 1 : (request('order_id')==2 ? 2 : (request('order_id')==3 ? 0 : null));
		$records = LaboratorioOrder::without('state_type', 'document_type', 'currency_type', 'group', 'items')
		->with('user','document_type','state_type')
		->whereBetween('date_of_issue', [request('fecha_inicio'), request('fecha_fin')])
		->where('nombre_cliente', 'like','%'. $busqueda.'%')
		->orWhere(DB::raw("CONCAT(`series`, '-', `number`)"), $busqueda)
		// ->orWhere(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(customer,'$.number') )"), 'like', "%{$busqueda}%")
		->orWhere(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(customer,'$.name') )"), 'like', "%{$busqueda}%")->where('estado',$idOrder);
		if(! auth()->user()->hasRole('administrador'))
		{
			$records = $records->where('establishment_id',auth()->user()->establishment_id);
		}
        return new OrderCollection($records->paginate(env('ITEMS_PER_PAGE', request('per_page'))));
    }

    public function records(Request $request)
    {
		$records = LaboratorioOrder::without('state_type', 'document_type', 'currency_type', 'group', 'items')
		->with('user','document_type','state_type');
		if(! auth()->user()->hasRole('administrador'))
		{

			$records = $records->where('establishment_id',auth()->user()->establishment_id);
		}

		$records  = $records->where(function ($query) use($request) {



			if(filter_var($request->eliminados, FILTER_VALIDATE_BOOLEAN))
			{
				$query->whereIn('estado',['0','1']);
			}
			else{
				$query->whereIn('estado',['1']);
			}

			if(filter_var($request->atendidos, FILTER_VALIDATE_BOOLEAN))
			{
				$query->whereIn('estado',['1','2']);
			}

			if($request->column == 'number') return $query->where(DB::raw("CONCAT(`series`, '-', `number`)"), 'like', "%{$request->value}%")->orWhere(DB::raw("CONCAT(`series`, '-', `number`)"), $request->value);
			else if($request->column == 'customer_id') return $query->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(orders.customer,'$.name') )"), 'like', "%{$request->value}%");
			else if($request->column == 'customer_number') return $query->where(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(orders.customer,'$.number') )"), 'like', "%{$request->value}%");
			else  $query->where($request->column, 'like', "%{$request->value}%")->orWhereNull($request->column);
		})->latest();
        return new OrderCollection($records->paginate(env('ITEMS_PER_PAGE', request('per_page'))));
    }

    public function totals(Request $request)
    {
		$data = [];
		if(auth()->user()->hasRole('administrador'))
		{
			$totalPEN = DB::connection('tenant')
			->table('orders')
			->select(DB::raw('COUNT(*) as quantity'), DB::raw('SUM(total) as total'))
			//->where($request->column, 'like', "%{$request->value}%")
			->where('currency_type_id', 'PEN')
						->first();

			$totalUSD = DB::connection('tenant')
					->table('orders')
					->select(DB::raw('COUNT(*) as quantity'), DB::raw('SUM(total) as total'))
					->where($request->column, 'like', "%{$request->value}%")
					->where('currency_type_id', 'USD')
					->first();

			$totalPEN = [
			'quantity' => $totalPEN->quantity,
			'total' => is_null($totalPEN->total) ? '0.00': $totalPEN->total
			];

			$totalUSD = [
			'quantity' => $totalUSD->quantity,
			'total' => is_null($totalUSD->total) ? '0.00' : $totalUSD->total
			];

			$data = [
				'totalPEN' => $totalPEN,
				'totalUSD' => $totalUSD
			];
		}
		else
		{
			$data = [
				'totalPEN' => 0,
				'totalUSD' => 0
			];
		}


        return compact('data');
    }

    public function create()
    {

        return view('orders.form');
    }

    public function edit($order_id)
    {
       return view('orders.edit', compact('order_id'));
    }

    public function tables()
    {
        $customers = $this->table('customers');

		//if(auth()->user()->hasRole('administrador'))
		if(auth()->user()->hasRole('administrador') || auth()->user()->hasRole('administrador-tienda'))
        {
            $establishments = Establishment::all();
        }
        else
        {
            $establishments = Establishment::where('id', auth()->user()->establishment_id)->get();
        }

        $series = Series::all();
        $document_types_invoice = DocumentType::whereIn('id', ['104'])->get();
        $currency_types = CurrencyType::whereActive()->get();
        $operation_types = OperationType::whereActive()->get();
        $discount_types = ChargeDiscountType::whereType('discount')->whereLevel('item')->get();
        $charge_types = ChargeDiscountType::whereType('charge')->whereLevel('item')->get();
        $company = Company::active();
        $document_type_03_filter = env('DOCUMENT_TYPE_03_FILTER', true);
		$decimal = Configuration::first()->decimal;

		$editar_precio = false;

		//if(auth()->user()->hasRole('administrador'))
		if(auth()->user()->hasRole('administrador') || auth()->user()->hasRole('administrador-tienda'))
        {
            $editar_precio = true;
        }
        else
        {
            $editar_precio = auth()->user()->hasPermissionTo('tenant.orders.edit_price');
        }

        return compact('customers', 'establishments', 'series', 'document_types_invoice', 'currency_types', 'operation_types',
                       'discount_types', 'charge_types', 'company', 'document_type_03_filter', 'decimal','editar_precio');
    }

    public function tables3($order_id = false)
    {
        if(strlen(stristr($order_id, 'e')) == 0)
        {
            $document_types_invoice = DocumentType::whereIn('id', ['104'])->get();
        }
        else
        {
            $document_types_invoice = DocumentType::whereIn('id', ['104'])->get();
        }

        $order_id = (int)$order_id;

        $order = LaboratorioOrder::whereId($order_id)->first();


        $customers = Person::whereType('customers')->without('country', 'department', 'province', 'district')->limit(5)->get()->transform(function ($row) {
            return [
                'id' => $row->id,
                'description' => $row->number . ' - ' . $row->name,
                'name' => $row->name,
                'number' => $row->number,
                'identity_document_type_id' => $row->identity_document_type_id,
                'identity_document_type_code' => $row->identity_document_type->code
            ];
        });

        //if(auth()->user()->hasRole('administrador'))
        if(auth()->user()->hasRole('administrador') || auth()->user()->hasRole('administrador-tienda'))
        {
            $establishments = Establishment::all();
        }
        else
        {
            $establishments = Establishment::where('id', auth()->user()->establishment_id)->get();
        }
        $sellers = $this->table('sellers');
        $warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();
        $warehouse_id = is_null($warehouse)?null:$warehouse->id;

        $warehouses = Warehouse::get();
        $series = Series::all();


        $currency_types = CurrencyType::whereActive()->get();
        $operation_types = OperationType::whereActive()->get();
        $discount_types = ChargeDiscountType::whereType('discount')->whereLevel('item')->get();
        $charge_types = ChargeDiscountType::whereType('charge')->whereLevel('item')->get();
        $company = Company::active();
        $document_type_03_filter = env('DOCUMENT_TYPE_03_FILTER', true);
        $config = Configuration::first();
        $inventoryConfig = InventoryConfiguration::first();
        $decimal = $config->decimal;
        $exchange_rate = $config->exchange_rate;
        $control_stock = $inventoryConfig->stock_control;
        $payment_methods = PaymentMethod::whereActive()->get();
        $accounts = Account::all();
        return compact('order','payment_methods','accounts' ,'customers', 'establishments', 'warehouse_id', 'warehouses','series',
            'document_types_invoice','control_stock'
            , 'currency_types', 'operation_types','sellers',
            'discount_types', 'charge_types', 'company', 'document_type_03_filter','exchange_rate' ,'decimal');
    }

    public function item_tables()
    {
        $items = $this->table('items');
        $categories = [];//Category::cascade();
        $affectation_igv_types = AffectationIgvType::whereActive()->get();
        $system_isc_types = SystemIscType::whereActive()->get();
        $price_types = PriceType::whereActive()->get();
        $operation_types = OperationType::whereActive()->get();
//        $discount_types = ChargeDiscountType::whereType('discount')->whereLevel('item')->get();
        $discount_types = ChargeDiscountType::whereType('discount')->whereLevel('item')->where('active',1)->get();
        $charge_types = ChargeDiscountType::whereType('charge')->whereLevel('item')->get();
        $attribute_types = AttributeType::whereActive()->orderByDescription()->get();

        return compact('items', 'categories', 'affectation_igv_types', 'system_isc_types', 'price_types',
                       'operation_types', 'discount_types', 'charge_types', 'attribute_types');
    }

    public function table($table)
    {
        if ($table === 'customers') {
            $customers = Person::where('id','<>',1)->whereType('customers')->orderBy('name')->get()->transform(function($row) {
                return [
                    'id' => $row->id,
                    'description' => $row->number.' - '.$row->name,
                    'name' => $row->name,
                    'number' => $row->number,
                    'identity_document_type_id' => $row->identity_document_type_id,
                    'identity_document_type_code' => $row->identity_document_type->code
                ];
            });
            return $customers;
        }
        if ($table === 'items') {
            $items = Item::with('equivalencias','currency_type')->orderBy('description')->get()->transform(function($row) {
                $full_description = ($row->internal_id)?$row->internal_id.' - '.$row->description:$row->description;

                return [
                    'id' => $row->id,
                    'full_description' => $full_description,
                    'description' => $row->description,
                    'currency_type_id' => $row->currency_type_id,
                    'currency_type_symbol' => $row->currency_type->symbol,
                    'sale_unit_price' => $row->sale_unit_price,
                    'purchase_unit_price' => $row->purchase_unit_price,
                    'unit_type_id' => $row->unit_type_id,
                    'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
                    'included_igv' => $row->included_igv,
                    'purchase_affectation_igv_type_id' => $row->purchase_affectation_igv_type_id,
                    'equivalencias' => $row->equivalencias->where('compra_venta',0)->all(),
                    'precios_compra'=> $row->equivalencias->where('compra_venta',1)->all(),
                    'precios_venta'=>  $row->equivalencias->where('compra_venta',2)->all(),
                ];
            });
            return $items;
        }

        return [];
    }

    public function record($id)
    {
        $record = new OrderResource(LaboratorioOrder::findOrFail($id));

        return $record;
    }

    public function store(OrderRequest $request)
    {
        $inputs = $request->all();

		$fact = DB::connection('tenant')->transaction(function () use ($request) {

			$DevPro = new LaboratorioOrder();
			$DevPro->save($request->all());
			return $DevPro;
		});
		$document = $fact->getDocument();

        return [
			'success' => true,
			'message'=> "Orden de Venta  {$document->series} {$document->number} Generada Correctamente",
			'id'=> $document,
        ];
    }

    public function update(OrderRequest $request, $order_id)
    {

        $orders = LaboratorioOrder::where('id',$order_id)->first();
        $inputs = $request->all();
        $inputs['series'] = $orders->series;
        $inputs['number'] = $orders->number;
        $inputs['document_type_id'] = $orders->document_type_id;
        $inputs['type_document_fact'] = '03';
        $inputs['filename'] = $orders->filename;

		session()->put('update_serie', true);
        $array = [$inputs, $order_id];

        $fact = DB::connection('tenant')->transaction(function () use ($array){

            $inputs = $array[0];
            $order_id = $array[1];

            $DevPro = new DevPro();
            $this->document = $DevPro->updateOrder($inputs, $order_id);
            return $this->document;
        });

        $document = $fact;
		session()->put('update_serie', false);
        return [
            'success' => true,
            'data' => [
                'id' => $document->id,
            ],
        ];
	}

	public function destroy($documet_id)
    {
        $register = DB::connection('tenant')->transaction(function () use ($documet_id)
        {

            LaboratorioOrder::where('id',$documet_id)->without('user', 'soap_type', 'state_type', 'document_type', 'currency_type', 'group', 'items', 'invoice', 'note','vendedor','order')->update(['estado'=>0]);
            OrderDetail::where('order_id', $documet_id)->without('affectation_igv_type', 'system_isc_type', 'price_type')->update(['estado'=>0]);

        });


		return [
            'success' => true,
            'data' => [
                'message' => "Documento eliminado satisfactoriamente"
            ],
        ];
    }

    public function items()
	{
		$search = request('search');
		$warehouse_id = request('warehouse_id');
		$type = 1;
		$searchCode =  request('searchCode',false);
		$inventory_configuration =  session('MOSTRAR_PRODUCTOS_SIN_STOCK') ?? DB::connection('tenant')->table('parametros')->where('nombre','MOSTRAR_PRODUCTOS_SIN_STOCK')
                    ->selectRaw('valor')
                    ->first();

		$items = UnidadEquivalente::where('codigo', $search)
			->where('compra_venta',2)
			->with('moneda','item.currency_type','trademark')
			->without('tipoprecio','moneda','almacen','unidad_equivalente','warehouses')
			->whereHas('item', function($q){
				$q->where('deleted_at', '=', null);
			})
			->whereHas('warehouses', function ( $query) use($warehouse_id,$inventory_configuration) {
				if($inventory_configuration->valor=='2')$query->where('stock', '>', 0)->where('warehouse_id',$warehouse_id);
			})
			->limit(config('tables.tenant.limit_items_search',25))
			->get();
		if($items->count()>0){
			$items = $items->transform(function ($row) use($warehouse_id){
				$full_description = ($row->item->internal_id) ? $row->item->internal_id . ' - ' . $row->item->description : $row->item->description;

//                .' - '. optional($row->trademark)->name
				return [
					'id' => $row->item->id,
					'full_description' => $full_description,
					'description' => $row->item->description,
					'internal_id' => $row->item->internal_id,
					'currency_type_id' => $row->item->currency_type_id,
					'currency_type_symbol' => $row->item->currency_type->symbol,
					'sale_unit_price' =>  optional(optional(optional($row->item)->equivalencias)->where('compra_venta',2)->first())->precio ?? 0,
					'purchase_unit_price' =>optional(optional(optional($row->item)->equivalencias)->where('compra_venta',1)->first())->precio ?? 0,
					'unit_type_id' => $row->item->unit_type_id,
					'included_igv' => $row->item->included_igv,
					'has_plastic_bag_taxes'=> $row->item->icbper,
					'amount_plastic_bag_taxes'=> $row->item->amount_plastic_bag_taxes,
					'sale_affectation_igv_type_id' => $row->item->sale_affectation_igv_type_id,
					'purchase_affectation_igv_type_id' => $row->item->purchase_affectation_igv_type_id,
					'precios_venta' => $row->item->equivalencias->where('compra_venta',2)->all(),
					'precios_compra' => $row->item->equivalencias->where('compra_venta',1)->all(),
					'type' => 1,
					'equivalencia_id'=> $row->id,
					'equivalencia_precio'=> $row->precio,
					'attributes' => $row->item->attributes ?? [],
					'included_igv' => $row->item->included_igv,
					'item_type_id' => $row->item->item_type_id,
					'item_code' => $row->item->item_code,
					'item_code_gs1' => $row->item->item_code_gs1,
					'maneja_puntos' => $row->item->maneja_puntos,
					'puntaje' => $row->item->puntaje,
					'avatar' => $row->item->avatar,
					'stockalmacenes'=>optional(optional($row->warehouses)->where('warehouse_id',$warehouse_id))->all(),
					'stock'=> optional(optional($row->warehouses)->where('warehouse_id',$warehouse_id))->sum('stock') ?? 0,
				];
			});
		}else{
		$items = Item::with('equivalencias.moneda','currency_type','warehouses','familia','trademark')
			->when($searchCode,function($query) use($search){
				$query->where('internal_id', '=', $search)
				->orWhere('codigo_personalizado', '=', $search);
			}, function( $query) use($search) {
				$query->where(function($q) use($search){
					$array = explode(" ",$search);
					foreach ($array as $value) {
						$q->where( DB::raw("REPLACE(description, ' ', '')"), 'LIKE','%'.$value.'%');
					}
				})
				->orWhereHas('trademark', function ( $query) use ($search) {
					$query->where('description', 'like',  '%'. $search.'%');
				})
				->orWhereHas('familia', function ( $query) use ($search) {
					$query->where('descripcion', 'like',  '%'. $search.'%');
				})
				->orWhere('internal_id', '=', $search)
				->orWhere('codigo_personalizado', '=', $search);
			})
			->whereHas('warehouses', function ( $query) use($warehouse_id,$inventory_configuration) {
				if($inventory_configuration->valor=='2')$query->where('stock', '>', 0)->where('warehouse_id',$warehouse_id);
			})
			->orderBy('description')
			->limit(config('tables.tenant.limit_items_search',25))
			->get()
			->transform(function ($row) use($warehouse_id) {
				$full_description = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;

				return [
					'id' => $row->id,
					'full_description' => $full_description,
					'description' => $row->description,
					'internal_id' => $row->internal_id,
					'codigo_personalizado' => $row->codigo_personalizado,
                    'marca' => optional($row->trademark)->name,
					'currency_type_id' => $row->currency_type_id,
					'currency_type_symbol' =>  optional($row->equivalencias->where('compra_venta',2)->first())->moneda->symbol ??  $row->currency_type->symbol,
					'sale_unit_price' =>  optional($row->equivalencias->where('compra_venta',2)->first())->precio ?? 0,
					'purchase_unit_price' => optional($row->equivalencias->where('compra_venta',1)->first())->precio ?? 0,
					'unit_type_id' => $row->unit_type_id,
					'included_igv' => $row->included_igv,
					'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
					'purchase_affectation_igv_type_id' => $row->purchase_affectation_igv_type_id,
					'has_plastic_bag_taxes'=> $row->icbper,
					'amount_plastic_bag_taxes'=> $row->amount_plastic_bag_taxes,
					'precios_venta' => $row->equivalencias->where('compra_venta',2)->all(),
					'precios_compra' => $row->equivalencias->where('compra_venta',1)->all(),
					'type' => 2,
					'equivalencia_id'=> null,
					'unidadbase'=> $row->equivalencias->where('compra_venta',0)->all(),
					'preciobase'=> $row->equivalencias->where('compra_venta',1)->where('unidad_medida_equivalente_id',$row->unit_type_id)->first(),
					'equivalencia_precio'=> null,
					'attributes' => $row->attributes ?? [],

					'stockalmacenes'=>optional(optional($row->warehouses)->where('warehouse_id',$warehouse_id))->all(),
					'stock'=> optional(optional($row->warehouses)->where('warehouse_id',$warehouse_id))->sum('stock') ?? 0,
                    'quantity' =>1
				];
			});
		}

		return compact('items');
	}

	public function pendientesTienda ()
	{
		$orders = LaboratorioOrder::where(['estado'=>1 , 'tipo'=>2])->count();

		return [
			'success'=>true,
			'message'=> $orders
		];
	}

    public function imprimir(Request $request, Order $order, $format)
    {

        $company = Company::first();
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();

        if($format=='a4'){
            $pdf = PDF::loadView('tenant.orders.order_a4', compact( "company", "order","establishment","format"));
            return $pdf->stream();
        }

        if($format=='ticket' || $format == 'despacho'){

            ini_set("pcre.backtrack_limit", "5000000");
            $html =  view('tenant.orders.order_ticket',  compact(  "company", "order","establishment","format"))->render();
            $company_name = (strlen($company->name) / 20) * 10;
            $company_address = (strlen($establishment->address) / 30) * 10;
            $company_number = $establishment->telephone != '' ? '10' : '0';
            $orderItemsCount = $order->items()->count() * 10;
            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [
                    78,
                    80 +
                    14 +
                    $company_name +
                    $company_address +
                    $company_number+
                    $orderItemsCount+
                    35
                ],
                'margin_top' => 2,
                'margin_right' => 5,
                'margin_bottom' => 0,
                'margin_left' => 5
            ]);

            $pdf->WriteHTML($html);
            return $pdf->Output();
        }
        return $pdf->stream();
    }
}