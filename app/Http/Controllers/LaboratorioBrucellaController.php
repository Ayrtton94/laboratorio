<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Serie;
use App\Models\Laboratorio_Brucella;
use App\Models\Laboratorio_detalles_brucellas;
use App\Models\Catalogs\DocumentType;
use App\Models\Catalogs\IdentityDocumentType;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LaboratorioBrucellaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laboratorio_brucella.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('laboratorio_brucella.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Laboratorio_Brucella = Laboratorio_Brucella::create($request->all());
    
        foreach ($request['data'] as $index => $test) {
            $datos = [
                'laboratorio_brucellas_id' => $Laboratorio_Brucella->id,
                'ruta' => $test[0] ?? null,
                'codigo' => $test[1] ?? null,
                'nombre' => $test[2] ?? null,
                'peso' => $test[3] ?? null,
                'v_prodccion' => $test[4] ?? null,
                't_hato' => $test[5] ?? null,
                'estado' => $test[6] ?? null,
            ];
    
            if (isset($request['dato1'][$index])) {
                $datos['dato1'] = $request['dato1'][$index];
            }
    
            if (isset($request['dato2'][$index])) {
                $datos['dato2'] = $request['dato2'][$index];
            }
    
            Laboratorio_detalles_brucellas::create($datos);
        }
    
        return response()->json([
            'success' => true,
            'message' => "Generada Correctamente",
            'id' => $Laboratorio_Brucella->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Laboratorio_Brucella  $laboratorio_Brucella
     * @return \Illuminate\Http\Response
     */
    public function show(Laboratorio_Brucella $laboratorio_Brucella)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Laboratorio_Brucella  $laboratorio_Brucella
     * @return \Illuminate\Http\Response
     */
    public function edit(Laboratorio_Brucella $laboratorio_Brucella)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Laboratorio_Brucella  $laboratorio_Brucella
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laboratorio_Brucella $laboratorio_Brucella)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Laboratorio_Brucella  $laboratorio_Brucella
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laboratorio_Brucella $laboratorio_Brucella)
    {
        //
    }

    public function tables()
    {
		$customers = $this->table('customers');
        $staffs = $this->table('staffs');
        $identity_document_types = IdentityDocumentType::where('active',1)->get();
        $documentTypes = DocumentType::where('active',1)->get();
        $serieDocument = Serie::where('document_type_id',104)->get();
        
        return compact('customers','staffs','identity_document_types','serieDocument');
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

    public function importar(Request $request)
    {
        $file = $request->file('excel_file');

        // Validar que se haya subido un archivo válido
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx'
        ]);
    
        // Cargar el archivo de Excel
        $spreadsheet = IOFactory::load($file->getRealPath());
    
        // Obtener los datos de la hoja activa del archivo
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();
    
        // Retornar los datos en formato JSON
        return response()->json($data);
    }
}
