<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\programBrucellaImport;
use Maatwebsite\Excel\Facades\Excel;

class ImprimierController extends Controller
{
    public function index()
    {
        return view('programabrucellas.imprimir');
    }

    public function ImportProductEcxel(Request $request)
    {
        $file = $request->file('documento');
        Excel::import(new programBrucellaImport, $file);
        return redirect('programabrucellas')->with('success', 'Productos importados exitosamente.');

    }

}
