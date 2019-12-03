<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class Waste extends Model
{
	use Importable;

    protected $guarded = [];

    public function model(array $row)
    {
    	return new Waste([
            'ler' => $row['LER'],
            'rut' => $row['RUT'],
            'entablishment' => $row['ESTABLECIMIENTO'],
            'process' => $row['TRATAMIENTO'],
            'quantity' => $row['CANTIDAD']
    	]);
    }
}
