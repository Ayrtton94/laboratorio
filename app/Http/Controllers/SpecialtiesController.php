<?php

namespace App\Http\Controllers;

use App\Models\Specialties;
use Illuminate\Http\Request;

class SpecialtiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Specialties::get();
    }

	public function records(){
		$specialties = Specialties::all();
		return response()->json(['specialties' => $specialties]);
	}

    public function store(Request $request)
    {
        $specialtiesa = new Specialties();
        $specialtiesa->create($request->all());
    }

    public function show(Specialties $specialtiesa)
    {
        return $specialtiesa;
    }

    public function update(Request $request, Specialties $specialtiesa)
    {
        $specialtiesa->update($request->all());

    }

    public function destroy(Specialties $specialtiesa)
    {

    }
}
