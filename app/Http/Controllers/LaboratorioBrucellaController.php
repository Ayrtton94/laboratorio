<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Serie;
use App\Models\Laboratorio_Brucella;
use App\Models\Catalogs\DocumentType;
use App\Models\Catalogs\IdentityDocumentType;
use Illuminate\Http\Request;

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
        //
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
}
