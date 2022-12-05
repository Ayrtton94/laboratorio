<?php

namespace App\Imports;


use App\Models\Matriz;
use App\Models\Muestra;
use App\Models\Person;
use App\Models\ProgramaBrucella;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProgramaBrucellaImport implements ToCollection
{
    use Importable;

    protected $data;

    public function collection(Collection $rows)
    {
        $total = count($rows);
        $registered = 0;
        unset($rows[0]);

        $repetido=0;
        $valorRepetido = [];
        foreach ($rows as $row)
        {

            $count =  ProgramaBrucella::query()->count();
            if($row[0] != "")
            {
                $muestra = ($row[0])?:null;
                $ruta = ($row[1])?:null;
                $num_supplier = ($row[2])?:null;
                $supplier = ($row[2])?:null;
                $peso = ($row[3])?:null;
                $parcela = ($row[4])?:null;
                $t_hato = ($row[5])?:null;
                $accion = ($row[6])?:null;
                $asignacion_modulo = ($row[7])?:null;
                $estado = ($row[8])?:null;

                $register = true;

                if($register) {

                    $supplierNew  = null;
                    if($supplier && ! empty(trim($supplier))){
                        $supplierNew = Person::where('descripcion', trim($supplier))->first();
                        if(!$supplierNew){
                            $supplierNew = Person::create([
                                'descripcion'=> trim($supplier)
                            ]);
                        }
                    }

                    $muestraNew = null;
                    if($muestra && ! empty(trim($muestra))){
                        $muestraNew = Muestra::where('name', trim($muestra))->first();
                        if(!$muestraNew){
                            $muestraNew = Muestra::create([
                                'description'=> trim($muestra),
                                'created_at' => now(),
                                'update_at' => now()
                            ]);
                        }
                    }

                    $register = ProgramaBrucella::query()->create([

                        'muestra' => $muestra,
                        'ruta' => $ruta,
                        'supplier' => $supplier,
                        'peso' => $peso,
                        'parcela' => $parcela,
                        't_hato' => $t_hato,
                        'accion' => $accion,
                        'asignacion_modulo' => $asignacion_modulo,
                        'estado' => $estado,

                    ]);


                    $muestras = Muestra::query()->where([
                        'description'=> $muestra,
                        'estado'=> 1])->first();

                    $matrices = Matriz::query()->where([
                        'id' => $muestras->matriz_id,
                        'estado'=> 1])->first();

                    if(is_null($muestras)){

                        $value = $register->matriz()->firstOrNew([
                            'id' => $muestras->matriz_id,
                            'estado'=> 1]);

                        $value->matriz_id = $muestras->matriz_id;
                        $value->description= $muestra;
                        $value->created_at = now();
                        $value->update_at = now();
                        $value->save();

                    }else{

                        $muestras->matriz_id = $matrices->id;
                        $muestras->description= $muestra;
                        $muestras->created_at = now();
                        $muestras->update_at = now();
                        $muestras->save();

                    }

                }


                $registered += 1;

            }
        }


        $this->data = compact('total', 'registered','repetido','valorRepetido');
    }

    public function getData()
    {
        return $this->data;
    }
}
