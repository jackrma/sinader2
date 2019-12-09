<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;
use App\Imports\WasteImport;
use Illuminate\Http\Request;

class WasteController extends Controller
{
    private $excel;
 
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }
    
    public function import()
    {
        (new WasteImport)->import(request()->file('your_file'));

        return redirect('/')->with('success', 'Archivo importado correctamente!');
    }

    
}
