<?php

 namespace App\Http\Controllers;

use App\Models\Catalogs\IdentityDocumentType;
use App\Models\Especie;
use App\Models\Matriz;
use App\Models\Muestra;
use App\Models\Person;
use App\Models\presentacion;
use App\Models\Prueba;
use App\Models\SubEspecie;
use Barryvdh\DomPDF\Facade as PDF;
use Mpdf\Mpdf;
use Nexmo\Account\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LaboratorioOrder;
use App\Models\District;
use App\Models\Province;
use App\Models\Department;

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

        $staffs = Person::whereType('staff')->without('country', 'department', 'province', 'district')->limit(5)->get()->transform(function ($row) {
            return [
                'id' => $row->id,
                'description' => $row->number . ' - ' . $row->name,
                'name' => $row->name,
                'number' => $row->number,
                'identity_document_type_id' => $row->identity_document_type_id
            ];
        });
        $identity_document_types = IdentityDocumentType::where('active',1)->get();
        $matrices = Matriz::all();
        $muestras = Muestra::all();
        $pruebas = Prueba::all();
        $especies = Especie::all();
        $subespecies = SubEspecie::all();
        $presentaciones = Presentacion::all();
		$departments = Department::where('active',1)->orderBy('description')->get();
        $provinces = Province::where('active',1)->orderBy('description')->get();
        $districts = District::where('active',1)->orderBy('description')->get();

        return compact('staffs','identity_document_types',
                'matrices','muestras','pruebas',
                'especies','subespecies','presentaciones','departments', 'provinces', 'districts');
    }

    public function record($id)
    {
        $record = new OrderResource(LaboratorioOrder::findOrFail($id));

        return $record;
    }

    public function store(OrderRequest $request)
    {
        try {

            $orderLaboratorio = new LaboratorioOrder();
            $orderLaboratorio->save($request->all());

            return [
                'success' => true,
                'message'=> "Orden Generada Correctamente",
                'id'=> $orderLaboratorio,
            ];

        }catch (\Exception $e) {
            return [
                'success' => true,
                'message'=> $e->getMessage()
            ];
        }


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
