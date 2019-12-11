<?php

namespace App\Imports;

use App\MonthWaste;
use Maatwebsite\Excel\Concerns\{Importable, ToModel, WithHeadingRow, WithValidation};

class MonthWasteImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MonthWaste([
            //
            'ler' => $row['LER'],
            'rut' => $row['RUT'],
            'entablishment' => $row['ESTABLECIMIENTO'],
            'process' => $row['TRATAMIENTO'],
            'quantity' => $row['CANTIDAD']
            'carrier' => $row['RUT TRANSPORTISTA'];
            'plate' => $row['PATENTE'];
            'date' => $row['FECHA'];
        ]);
    }

    public function rules()
    {
        return [
            'entablishment' => 'regex:/[0-9]{3}/',
            'license_plate' => 'regex:/[A-Z]{3}-[0-9]{3}/',

        ];
    }
}
