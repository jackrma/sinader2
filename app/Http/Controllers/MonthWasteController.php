<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Imports\MonthWasteImport;


class MonthWasteController extends Controller
{
    private $excel;
 
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }
    
    public function import()
    {
        (new MonthWasteImport)->import(request()->file('your_file'));

        return redirect('/')->with('success', 'Archivo importado correctamente!');
    }
}
