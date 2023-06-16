<?php

namespace App\Imports;

use App\Models\Muestra;
use App\Models\Person;
use App\Models\ProgramaBrucella;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class programBrucellaImport implements ToModel, WithHeadingRow, WithUpserts
{
    protected $data;

    public function model(array $row)
    {

        $muestra = $row['muestra'] ?? null;
        $ruta = $row['ruta'] ?? null;
        $num_supplier = $row['documento'] ?? null;
        $supplier = $row['proveedor'] ?? null;
        $peso = $row['peso'] ?? null;
        $parcela = $row['parcela'] ?? null;
        $v_produccion = $row['v_produccion'] ?? null;
        $t_hato = $row['tiempo_hato'] ?? null;
        $accion = $row['accion'] ?? null;
        $asignar_modulo = $row['asignar_modulo'] ?? null;

        $muestras = Muestra::query()->where(['description' => $muestra, 'estado' => 1])->first();
        $suppliers = Person::query()->where('type', 'suppliers')->where('number', $num_supplier)->first();

        //dd($row);

        if ($muestra && $suppliers) {
            $registerProgramaBrucella = ProgramaBrucella::query()
                ->where('parcela', $parcela)
                ->where('supplier_id', $suppliers->id)
                ->first();

                

            if ($registerProgramaBrucella) {
                $registerProgramaBrucella->update([
                    'muestra_id' => $muestras->id,
                    'ruta' => $ruta,
                    'peso' => $peso,
                    'v_produccion' => $v_produccion,
                    't_hato' => $t_hato,
                    'accion' => $accion,
                    'asignar_modulo' => $asignar_modulo
                ]);
            } else {
                $registerProgramaBrucella = new ProgramaBrucella([
                    'muestra_id' => $muestras->id,
                    'ruta' => $ruta,
                    'supplier_id' => $suppliers->id,
                    'peso' => $peso,
                    'parcela' => $parcela,
                    'v_produccion' => $v_produccion,
                    't_hato' => $t_hato,
                    'accion' => $accion,
                    'asignar_modulo' => $asignar_modulo
                ]);
                $registerProgramaBrucella->save();
            }
        }
    }

    public function uniqueBy()
    {
        return 'number';
    }
}
