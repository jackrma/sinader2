<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class MonthWaste extends Model
{
	use Importable;

    protected $guarded = [];

    public function model(array $row)
    {
    	return new MonthWaste([
            'ler' => $row['LER'],
            'rut' => $row['RUT'],
            'entablishment' => $row['ESTABLECIMIENTO'],
            'process' => $row['TRATAMIENTO'],
            'quantity' => $row['CANTIDAD']
            'carrier' => $row['RUT TRANSPORTISTA'];
            'license_plate' => $row['PATENTE'];
            'date' => $row['FECHA'];
    	]);
    }
}
}
