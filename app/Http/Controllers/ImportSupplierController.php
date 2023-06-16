<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\SupplierImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportSupplierController extends Controller
{
    public function index()
    {
        return view('persons.import');
    }

    public function ImportProovedorEcxel(Request $request)
    {
        $file = $request->file('documento');
        Excel::import(new SupplierImport, $file);
        return redirect('importar_proveedor')->with('success', 'Proveedor importados exitosamente.');

    }
}
