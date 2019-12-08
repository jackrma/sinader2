<?php

namespace App\Http\Controllers;

use App\Declaration;
use App\User;
use App\UserEstablishment;
use App\Establishment;
use App\WasteDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DeclarationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $declarations = Declaration::all();
        return response()->json($declarations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = Auth::user();
        $user_establishment = UserEstablishment::where('user_id', $user->id)->first();

        Info($user_establishment);
        $last_declaration = Declaration::where('establishment_id', $user_establishment->establishment_id)->get()->last();

        $declaration = new Declaration();
        $declaration->correlative       = 1;
        if($last_declaration){
            $declaration->correlative   = $last_declaration->correlative + 1; 
        }
        
        $declaration->correlative_dv    = $this->getMod11Dv($declaration->correlative);
        $declaration->establishment_id  = $user_establishment->establishment_id;
        $declaration->user_id           = $user->id;   
        $declaration->status            = 'CREADA';

        // $declaration->save();

        return response()->json($declaration);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $user_establishment = UserEstablishment::where('user_id', $user->id)->first();

        $declaration = $request->Input('declaration');


        $declarationNew = Declaration::where('correlative', $declaration["correlative"])->get()->first();

        if(!$declarationNew){
            $declarationNew = new Declaration();
        }
        
        $declarationNew->correlative    = $declaration['correlative'];       
        $declarationNew->correlative_dv = $declaration['correlative_dv']; 
        $declarationNew->type           = $declaration['type'];
        $declarationNew->period         = $declaration['period'];
        $declarationNew->status            = 'CREADA';
        $declarationNew->establishment_id  = $user_establishment->establishment_id;
        $declarationNew->user_id           = $user->id;

        if ($declarationNew->save() ){
            WasteDetail::where('declaration_id', $declarationNew->declaration_id)->delete();
            $this->storeDetail($declaration['waste_detail'], $declarationNew->id);
        }

        return response()->json($declarationNew);
    }


    public function storeDetail($residues, $declaration_id){

        foreach ($residues as $waste ) {
            
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
            $waste_detail->manage_id        = $waste['gestion_id'];
            $waste_detail->process_id       = $waste['process_id'];
            $waste_detail->unit_id          = $waste['unit_id'];

            $waste_detail->carrier_id       = $waste['carrier_id'];

            $waste_detail->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function show(Declaration $declaration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function edit(Declaration $declaration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Declaration $declaration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Declaration $declaration)
    {
        //
    }
    
    public function pdf()
    {        

        // $pdf = PDF::loadView('Declaration', compact('declaration'));

        // return $pdf->download('Declaracion.pdf');
    }

    function getMod11Dv( $num ){
    /* --------------------------------------------------------------------------------------- */
      $digits = str_replace( array( '.', ',' ), array( ''.'' ), strrev($num ) );
      if ( ! ctype_digit( $digits ) )
      {
        return false;
      }

      $sum = 0;
      $factor = 2;
     
      for( $i=0;$i<strlen( $digits ); $i++ )
      {
        $sum += substr( $digits,$i,1 ) * $factor;
        if ( $factor == 7 )
        {
          $factor = 2;
        }else{
         $factor++;
       }
      }
     
      $dv = 11 - ($sum % 11);
      if ( $dv < 10 )
      {
        return $dv;
      }
      if ( $dv == 10 )
      {
        return 'K';
      }
      return 0;
    }


}
