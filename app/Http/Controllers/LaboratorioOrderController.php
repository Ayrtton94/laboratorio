<?php

 namespace App\Http\Controllers;

use Mpdf\Mpdf;
use App\Models\Serie;
use App\Models\Matriz;
use App\Models\Metodo;
use App\Models\Person;
use App\Models\Prueba;
use App\Models\Company;
use App\Models\Especie;
use App\Models\Muestra;
use App\Models\District;
use App\Models\Province;
use Nexmo\Account\Price;
use App\Models\Department;
use App\Models\SubEspecie;
use App\Inputs\PersonInput;
use App\Models\Laboratorio;
use App\Models\presentacion;
use Illuminate\Http\Request;
use App\Models\Establishment;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\IdentityDocument;
use App\Models\LaboratorioOrder;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Catalogs\CurrencyType;
use App\Models\Catalogs\DocumentType;
use App\Models\LaboratorioOrderDetail;
use App\Models\Catalogs\IdentityDocumentType;
use App\Http\Resources\OrderLaboratorioResource;
use App\Http\Resources\OrderLaboratorioCollection;

class LaboratorioOrderController extends Controller
{
    public function __construct()
    {
//        $this->middleware('input.request:order,web', ['only' => ['store', 'update']]);
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
			'customer_id' => 'Nombre / Razón Social',
			'tporden_id' => 'Tipo Orden'
        ];
    }

    public function records(Request $request)
    {
		$records = LaboratorioOrder::with('items');
		
		$records  = $records->where(function ($query) use($request) {
			if($request->value)
			{
				if($request->column == 'number') return $query->where(DB::raw("CONCAT(`series`, '-', `number`)"), $request->value);
				else if($request->column == 'customer_id') return $query->where('customer_id', $request->value);
				else if($request->column == 'tporden_id') return $query->where('tporden_id', $request->value);
				else  $query->where($request->column, 'like', "%{$request->value}%")->orWhereNull($request->column);
			}
		});
		
		return new OrderLaboratorioCollection($records->paginate(env('ITEMS_PER_PAGE', request('per_page'))));
    }

    public function create()
    {

        return view('orders.form');
    }

    public function edit($order_id)
    {
       return view('orders.edit', compact('order_id'));
    }

	public function tables3($order_id = false)
    {
       
        $document_types_invoice = DocumentType::whereIn('id', ['104'])->get();
        $order_id = (int)$order_id;
        $order = LaboratorioOrder::with('items')->whereId($order_id)->first();

        $customers = Person::whereType('customers')->without('country', 'department', 'province', 'district')->limit(5)->get()->transform(function ($row) {
            return [
                'id' => $row->id,
                'description' => $row->number . ' - ' . $row->name,
                'name' => $row->name,
                'number' => $row->number,
                'identity_document_type_id' => $row->identity_document_type_id
            ];
        });
        $series = Serie::all();
        $currency_types = CurrencyType::all();
        $document_type_03_filter = env('DOCUMENT_TYPE_03_FILTER', true);

        return compact('order','customers', 'series', 'document_types_invoice', 'currency_types',  'document_type_03_filter');
    }

    public function tables()
    {
		$customers = $this->table('customers');
        $staffs = $this->table('staffs');
        $identity_document_types = IdentityDocumentType::where('active',1)->get();
        $documentTypes = DocumentType::where('active',1)->get();
        $serieDocument = Serie::where('document_type_id',104)->get();
        $matrices = Matriz::all();
        $muestras = Muestra::all();
        $pruebas = Prueba::all();
        $especies = Especie::all();
        $subespecies = SubEspecie::all();
        $presentaciones = Presentacion::all();
        $laboratorios = Laboratorio::all();
        $metodos = Metodo::all();
		$departments = Department::where('active',1)->orderBy('description')->get();
        $provinces = Province::where('active',1)->orderBy('description')->get();
        $districts = District::where('active',1)->orderBy('description')->get();

        return compact('customers','staffs','identity_document_types',
                'matrices','muestras','pruebas','serieDocument','laboratorios','metodos',
                'especies','subespecies','presentaciones','departments', 'provinces', 'districts');
    }

	public function table($table)
    {
        if ($table === 'staffs') {
			 $staffs = Person::whereType('staff')->without('country', 'department', 'province', 'district')->limit(5)->get()->transform(function ($row) {
				return [
					'id' => $row->id,
					'description' => $row->number . ' - ' . $row->name,
					'name' => $row->name,
					'number' => $row->number,
					'identity_document_id' => $row->identity_document_id
				];
			});
            return $staffs;
        }
        if ($table === 'customers') {
			$customers = Person::whereType('customers')->without( 'country', 'department', 'province', 'district')->limit(5)->get()->transform(function ($row) {
				return [
					'id' => $row->id,
					'description' => $row->number . ' - ' . $row->name,
					'name' => $row->name,
					'number' => $row->number,
					'identity_document_id' => $row->identity_document_id
				];
			});
            return $customers;
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
        $orderLaboratorio = DB::transaction(function () use ($request) {

            $customer = PersonInput::set($request->input('customer_id'));
            $serieDocument = Serie::query()->where('document_type_id',104)->first();
            $request['customer'] = $customer;
            $request['series'] = $serieDocument->serie;
            $request['number'] = $serieDocument->number;
            $orderLaboratorio = LaboratorioOrder::create($request->all()+['user_id'=>auth()->id()]);

            if (count($request['tests']) > 0) {
                foreach ($request['tests'] as $test) {
                    for ($i = 0; $i < $test['quantity']; $i++) {
                        LaboratorioOrderDetail::query()->create([
                            'laboratorio_order_id' => $orderLaboratorio->id,
                            'matriz_id' => $test['matriz_id'] ?? null,
                            'muestra_id' => $test['muestra_id'] ?? null,
                            'prueba_id' => $test['prueba_id'] ?? null,
                            'especie_id' => $test['especie_id'] ?? null,
                            'subespecie_id' => $test['especie_id'] ?? null,
                            'presentacion_id' => $test['presentacion_id'] ?? null,
                            'quantity' => 1,
                            'observacion' => $test['observacion'] ?? null,
                            'date_of_muestra' => $test['date_of_muestra'],
                            'date_of_recepcion' => $test['date_of_recepcion'],
                            'date_of_resultado' => $test['date_of_result'],
                            'temperatura' => $test['temperatura'] ?? 0,
                            'unit_value' => 0,
                            'unit_price' => 0,
                            'total_igv' => 0,
                            'total_value' => 0,
                            'total' => $test['price_total'],
                            'attributes' => null
                        ]);
                    }
                }
            }
            
            $serieDocument->update([
                'number'=> $orderLaboratorio->number + 1
            ]);
        });

        return response()->json([
            'success' => true,
            'message'=> "Orden Generada Correctamente",
            'id'=> $orderLaboratorio,
        ]);
        
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

    public function imprimir(Request $request, LaboratorioOrder $order, $format)
    {
		
        $company = Company::first();
        $establishment = Establishment::where('id', 1)->first();

        if($format=='a4'){
            $pdf = Pdf::loadView('orders.order_a4', compact( "company", "order","establishment","format"));
            return $pdf->stream();
        }

        if($format=='ticket'){

            ini_set("pcre.backtrack_limit", "5000000");
            $html =  view('orders.order_ticket',  compact(  "company", "order","establishment","format"))->render();
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
                    $orderItemsCount
                ],
                'margin_top' => 2,
                'margin_right' => 5,
                'margin_bottom' => 0,
                'margin_left' => 5
            ]);

            $pdf->WriteHTML($html);
            return $pdf->Output();
			return $pdf->stream();
        }
    }

	public function evaluacionData($id)
{
    $record = LaboratorioOrder::with('items')->find($id);

    if (!$record) {
        return response()->json(['message' => 'Registro no encontrado'], 404);
    }

    $transformedRecord = new OrderLaboratorioResource($record);

    return response()->json($transformedRecord);
}

	public function updatePayment($id,Request $request)
	{
		$records = LaboratorioOrder::where('id', $id)->first();
		
		if($records){
			$records->update([
				'status_paid' => $request->input('payment_id'),
                'payment_end' => today()
			]);
		}
		return [
            'success' => true,
            'message' => 'Pago Actualizado'
        ];
	}

    public function updateSorder($id, Request $request)
{
       
    $records = LaboratorioOrder::where('id', $id)->first();
    
    if ($records) {
        $records->update([
            'status_order' => $request->input('status_order'),
            'comentario' => $request->input('comentario'),
        ]);
    }
    
    return [
        'success' => true,
        'message' => 'Pago Actualizado'
    ];
}

    public function updateResultado($id, Request $request)
{
    $records = LaboratorioOrderDetail::where('id', $id)->first();

    if($records){
        $records->update([
            'age_select' => $request->input('age_select'),
            'lote' => $request->input('lote'),
            'datef' => $request->input('datef'),
        ]);
    }
    return [
        'success' => true,
        'message' => 'Resultado Actualizado'
    ];
}

public function pruebalav($id)
{
    $records = LaboratorioOrderDetail::select('prueba_id', 'matriz_id')->where('laboratorio_order_id', $id)->get();
    $detalle = [];    
    
    foreach ($records as $record) {
          
        $pruebas = Prueba::where('id', $record->prueba_id)->get();
        $matrizes = Matriz::where('id', $record->matriz_id)->get();
        
        foreach ($pruebas as $prueba) {
            foreach($matrizes as $matrize){
                $detalle[] = [
                    'prueba' => $prueba->name,
                    'matriz' => $matrize->description              
                ];               
            }            
        }
    }    
    return response()->json($detalle, 200);
}




public function lisprmimu($id)
{
    $records = LaboratorioOrderDetail::select('prueba_id', 'matriz_id','muestra_id')->where('id', $id)->get();
    $detalle = [];    
    
    foreach ($records as $record) {
          
        $pruebas = Prueba::where('id', $record->prueba_id)->get();
        $matrizes = Matriz::where('id', $record->matriz_id)->get();
        $muestras = Muestra::where('id', $record->muestra_id)->get();
        
        foreach ($pruebas as $prueba) {
            foreach($matrizes as $matrize){
                foreach($muestras as $muestra){
                    $detalle[] = [
                        'prueba' => $prueba->name,
                        'matriz' => $matrize->description,
                        'muestar'=> $muestra->description,              
                    ];
                }                
            }            
        }
    }    
    return response()->json($detalle, 200);
}
public function detalle($id)
{
    $records = LaboratorioOrderDetail::select('id')->where('laboratorio_order_id', $id)->get();  
    return response()->json($records, 200);
}

public function dato_detalle($id)
{
    $records = LaboratorioOrderDetail::where('id', $id)->get(); 
    $detalle = [];
    foreach($records as $record){
        $pruebas = Prueba::where('id', $record->prueba_id)->get();
        $matrizes = Matriz::where('id', $record->matriz_id)->get();
        $muestras = Muestra::where('id', $record->muestra_id)->get();

        foreach ($pruebas as $prueba) {
            foreach($matrizes as $matrize){
                foreach($muestras as $muestra){
                    $detalle[] = [
                        'date_of_muestra' => $record->date_of_muestra,
                        'date_of_recepcion' => $record->date_of_recepcion,
                        'date_of_resultado' => $record->date_of_resultado,
                        'temperatura' => $record->temperatura,
                        'quantity' => $record->quantity,
                        'observacion' => $record->observacion,
                        'prueba' => $prueba->name,
                        'matriz' => $matrize->description,
                        'muestar'=> $muestra->description,              
                    ];
                }                
            }            
        }
    }   
    return response()->json($detalle, 200);
}

}