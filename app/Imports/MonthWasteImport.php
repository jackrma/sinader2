<?php

namespace App\Imports;

use App\MonthWaste;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\{Importable, ToModel, WithHeadingRow, WithValidation};

class MonthWasteImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    use Importable;

    public function model(array $row)
    {
        return new MonthWaste([
            //
            'id' => $row['ID'],
            'ler' => $row['LER'],
            'rut' => $row['RUT'],
            'entablishment' => $row['ESTABLECIMIENTO'],
            'process' => $row['TRATAMIENTO'],
            'quantity' => $row['CANTIDAD']
            'carrier' => $row['RUT TRANSPORTISTA'],
            'plate' => $row['PATENTE'],
            'date' => $row['FECHA'],
        ]);
    }

    public function rules()
    {
        return [
            'entablishment' => 'regex:/[0-9]{3}/',
            'plate' => 'regex:/[A-Z]{3}-[0-9]{3}/',

            'ler' => 'required',
            'rut' => 'required',
            'entablishment' => 'required',
            'process' => 'required',
            'quantity' => 'required',
            'carrier' => 'required'
            'plate' => 'required',
            'date' => 'required'

        ];
    }

    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
        \Log::error($e->getMessage());
         return back();
    }
}
