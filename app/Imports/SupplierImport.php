<?php
namespace App\Imports;

use App\Models\Person;
use App\Models\Province;
use App\Models\Department;
use App\Models\District;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class SupplierImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row)
    {
        $department = Department::where('description', $row['department_id'])->first();
        $province = Province::where('description', $row['province_id'])->first();
        $district = District::where('description', $row['district_id'])->first();

        return Person::updateOrCreate(
            ['number' => $row['number']], // Buscar por el campo 'number'
            [
                'type' => 'suppliers',
                'identity_document_id' => '1',
                'empresa' => $row['empresa'],
                'codigo' => $row['codigo'],
                'ruta' => $row['ruta'],
                'porongo' => $row['porongo'],
                'name' => $row['name'],
                'address' => $row['address'],
                'department_id' => $department ? $department->id : null,
                'province_id' => $province ? $province->id : null,
                'district_id' => $district ? $district->id : null,
                'ancho' => $row['ancho'],
            ]
        );
    }

    public function uniqueBy()
    {
        return 'number';
    }
}
