<?php

namespace App\Imports;

use App\Models\Muestra;
use App\Models\Person;
use App\Models\ProgramaBrucella;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;

class programBrucellaImport implements ToCollection
{
    use Importable;
    protected $data;

    public function collection(Collection $rows)
    {

        $total = count($rows);
        $registered = 0;
        unset($rows[0]);

        foreach ($rows as $row)
        {

            if($row[0] != "")
            {

                $muestras = ($row[0])?:null;
                $ruta = ($row[1])?:null;
                $num_supplier = ($row[2])?:null;
                $supplier = ($row[3])?:null;
                $peso = ($row[4])?:null;
                $parcela = ($row[5])?:null;
                $v_produccion = ($row[6])?:null;
                $t_hato = ($row[7])?:null;
                $accion = ($row[8])?:null;
                $asignar_modulo = ($row[9])?:null;

//                    $muestraNew = null;
//                    if($muestra && ! empty(trim($muestra))){
//                        $muestraNew = Muestra::where('name', trim($muestra))->first();
//                        if(!$muestraNew){
//                            $muestraNew = Muestra::create([
//                                'description'=> trim($muestra),
//                                'created_at' => now(),
//                                'update_at' => now()
//                            ]);
//                        }
//                    }
                    $muestra = Muestra::query()->where(['description'=> $muestras, 'estado'=> 1])->first();
//                    dd($muestra->id);
                    $suppliers = Person::query()->where('type', 'suppliers')->where('number', $num_supplier)->first();
//                    dd($suppliers);
                    $registerProgramaBrucella = ProgramaBrucella::query()->where('parcela', $parcela)->where('supplier_id', $suppliers->id)->first();

                    if(!$registerProgramaBrucella){
                        ProgramaBrucella::query()->create([

                            'muestra_id' => $muestra->id,
                            'ruta' => $ruta,
                            'supplier_id' => $suppliers->id,
                            'peso' => $peso,
                            'parcela' => $parcela,
                            'v_produccion' => $v_produccion,
                            't_hato' => $t_hato,
                            'accion' => $accion,
                            'asignar_modulo' => $asignar_modulo

                        ]);
                    }else{
                         ProgramaBrucella::query()->update([
                            'muestra_id' => $muestra->id,
                            'ruta' => $ruta,
                            'supplier_id' => $suppliers->id,
                            'peso' => $peso,
                            'parcela' => $parcela,
                            'v_produccion' => $v_produccion,
                            't_hato' => $t_hato,
                            'accion' => $accion,
                            'asignar_modulo' => $asignar_modulo

                        ]);
                    }

//                    $muestras = Muestra::query()->where([
//                        'description'=> $muestra,
//                        'estado'=> 1])->first();
//
//                    $matrices = Matriz::query()->where([
//                        'id' => $muestras->matriz_id,
//                        'estado'=> 1])->first();
//
//                    if(is_null($muestras)){
//
//                        $value = $register->matriz()->firstOrNew([
//                            'id' => $muestras->matriz_id,
//                            'estado'=> 1]);
//
//                        $value->matriz_id = $muestras->matriz_id;
//                        $value->description= $muestra;
//                        $value->created_at = now();
//                        $value->update_at = now();
//                        $value->save();
//
//                    }else{
//
//                        $muestras->matriz_id = $matrices->id;
//                        $muestras->description= $muestra;
//                        $muestras->created_at = now();
//                        $muestras->update_at = now();
//                        $muestras->save();
//
//                    }

                }

                $registered += 1;

            }


        $this->data = compact('total', 'registered');
    }

    public function getData()
    {
        return $this->data;
    }
}
