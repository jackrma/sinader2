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

    public function saveDeclaration()
    {

        $user = Auth::user();
        $monthwaste = monthwaste::all()->toArray();
        
        foreach ($monthwaste as $waste ) {
            
            $declaration = new Declaration();
            

            $establishment = Establishment::where('retc_code', $waste->entablishment)->first();

            $last_declaration = Declaration::where('establishment_id', $establishment->id)->get()->last();

            $declaration = new Declaration();
            $declaration->correlative       = $waste['waste'];
            if($last_declaration){
                $declaration->correlative   = $last_declaration->correlative + 1; 
            }
            
            $declaration->correlative_dv    = $this->getMod11Dv($declaration->correlative);
            $declaration->establishment_id  = $waste['entablishment'];
            $declaration->user_id           = $user->id;   
            $declaration->status            = 'CREADA';

            $declarationNew->save() 

            $waste_detail = new WasteDetail();

            $waste_detail->declaration_id   = $declaration_id;

            $waste_detail->waste            = $waste['waste'];   

            $waste_detail->company          = $waste['company'];
            $waste_detail->establishment    = $waste['establishment'];
            $waste_detail->processing       = $waste['processing'];
            $waste_detail->gestion          = $waste['gestion'];
            
            $waste_detail->pais             = $waste['pais'];
            $waste_detail->empresa          = $waste['empresa'];
            $waste_detail->contacto         = $waste['contacto'];
            $waste_detail->email            = $waste['email'];

            $waste_detail->quantity         = $waste['quantity'];
            $waste_detail->waste_id         = $waste['waste_id'];
            $waste_detail->company_id       = $waste['company_id'];
            $waste_detail->establishment_id = $waste['establishment_id'];
            $waste_detail->manage_id        = $waste['manage_id'];
            $waste_detail->process_id       = $waste['process_id'];
            $waste_detail->unit_id          = $waste['unit_id'];

            $waste_detail->carrier_id       = $waste['carrier_id'];

            $waste_detail->save();

        }
    }
}
