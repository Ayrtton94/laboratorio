<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\District;
use App\Models\Province;
use App\Models\Department;
use App\Models\IdentityDocument;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('company.index');
    }

    public function records()
	{
		$companys = Company::get();
		return ['companys' => $companys];
	}

    public function store(Request $request)
    {
        try {
			$id = $request->input('id');
			$company = Company::firstOrNew(['id' => $id]);
			$company->fill($request->all());
			$company->save();

			return [
				'success' => true,
				'message' => ($id) ? 'Registro Actualizado' : 'Registro Exitoso'
			];
		} catch (\Throwable $th) {

			return [
                'success' => false,
                'message' => $th->getMessage()
            ];
		}
    }

    public function show(Company $company)
    {
        //
    }

    public function edit(Company $company)
    {
        //
    }

    public function update(Request $request, Company $company)
    {
        //
    }

    public function tables()
    {
        $departments = Department::where('active',1)->orderBy('description')->get();
        $provinces = Province::where('active',1)->orderBy('description')->get();
        $districts = District::where('active',1)->orderBy('description')->get();
        $identity_document_types = IdentityDocument::where('status',1)->get();

        return compact('departments', 'provinces', 'districts', 'identity_document_types');
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
		$company->update(['status' => 0]);
		$company->delete();

		return [
			'success' => true,
			'message' => 'Cliente Eliminado con exito'
		];
    }

    public function restore($id)
    {
        $company = Company::withTrashed()->findOrFail($id);
		$company->update(['status' => 1]);
		$company->restore();

		return [
			'success' => true,
			'message' => 'Cliente Restaurado con exito'
		];
    }

}
