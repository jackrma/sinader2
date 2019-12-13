<?php

namespace App\Http\Controllers;

use App\Declaration;
use App\User;
use App\UserEstablishment;
use App\Establishment;
use App\WasteDetail;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DeclarationController extends Controller
{
  
    public function index()
    {
        $user = Auth::user();
        $user_establishment = UserEstablishment::where('user_id', $user->id)->first();

        $declarations = Declaration::where('establishment_id',$user_establishment->establishment_id)->get();
        return response()->json($declarations);
    }


    public function forreceiver($receiver_id){
        $declarations = Declaration::join('waste_details','declarations.id',"=",'waste_details.declaration_id')->where('waste_details.establishment_id',$receiver_id)->get();
        return response()->json($declarations);   
    }


    public function declaration($declaration_id){
        $declaration = Declaration::where('id', $declaration_id)->get()->first();
        return response()->json($declaration);   
    }

    public function create()
    {

        $user = Auth::user();
        $user_establishment = UserEstablishment::where('user_id', $user->id)->first();

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


        Info($request);

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

        $declarationNew->rut            = $declaration['rut'];
        $declarationNew->company        = $declaration['company'];
        $declarationNew->establishment  = $declaration['establishment'];
        $declarationNew->direccion      = $declaration['direccion'];
        $declarationNew->comuna         = $declaration['comuna'];
        $declarationNew->region         = $declaration['region'];
 
        $declarationNew->status            = 'CREADA';
        $declarationNew->establishment_id  = $user_establishment->establishment_id;
        $declarationNew->user_id           = $user->id;

        if ($declarationNew->save() ){
            WasteDetail::where('declaration_id', $declarationNew->id)->delete();
            $this->storeDetail($declaration['waste_detail'], $declarationNew->id, 0);
        }

        return response()->json($declarationNew);
    }


    public function storeDetail($residues, $declaration_id, $declaration_origin_id){

        Info("**************************");
        Info($residues);

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
            $waste_detail->manage_id        = $waste['manage_id'];
            $waste_detail->process_id       = $waste['process_id'];
            $waste_detail->unit_id          = $waste['unit_id'];
            $waste_detail->status           = 'ENVIADO';

            if(array_key_exists('carrier_id',$waste)){
                $waste_detail->carrier_id = $waste['carrier_id'];
            } else {
                $waste_detail->carrier_id = 1;
            }

            $waste_detail->save();
        }
    }

    public function savetraceability(Request $request){

        // Info($request);

        $declaration_origin = $request->input('declaration_origin');
        $waste_detail       = $request->input('waste_detail');


        $user = Auth::user();

        $user_establishment = UserEstablishment::where('user_id', $user->id)->first();
        $establishment = Establishment::where('id', $user_establishment->establishment_id)->get()->first();
        $company = Company::where('id',$establishment->company_id)->get()->first();


        $last_declaration = Declaration::where('establishment_id', $user_establishment->establishment_id)->get()->last();

        $declaration = new Declaration();
        $declaration->correlative       = 1;
        if($last_declaration){
            $declaration->correlative   = $last_declaration->correlative + 1; 
        }
        
        $declaration->declaration_origin_id = $declaration_origin['id'];
        $declaration->correlative_dv    = $this->getMod11Dv($declaration->correlative);
        $declaration->establishment_id  = $user_establishment->establishment_id;
        $declaration->user_id           = $user->id;   
        $declaration->status            = 'CREADA';

        $declaration->rut            = $company->rut . '-' . $company->dv;
        $declaration->company        = $company->name;
        $declaration->establishment  = $establishment->name;
        $declaration->direccion      = $establishment->street . ' ' . $establishment->number;
        $declaration->comuna         = $establishment->commune->name;
        $declaration->region         = $establishment->region->name;
        $declaration->type           = ' ';
        $declaration->period         = '2019';
        
 
        $declaration->establishment_id  = $user_establishment->establishment_id;
        $declaration->user_id           = $user->id;

        if ($declaration->save() ){
            WasteDetail::where('declaration_id', $declaration->id)->delete();
            $this->storeDetail($waste_detail, $declaration->id, $declaration_origin['id']);
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
        
    }
    
    public function delete($declaration_id)
    {
        Declaration::where('id',$declaration_id)->delete();
       
        WasteDetail::where('declaration_id',$declaration_id)->delete();
        
        return response()->json($declaration_id);
    }


    public function changeStatusEnviada($declaration_id)
    {
        $declaration = Declaration::where('id',$declaration_id)->get()->first();
        $declaration->status = 'ENVIADA';
        $declaration->save();
        
        return response()->json($declaration);
    }


    public function sinMovimento(Request $request)
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
        $declarationNew->status            = 'SINMOVIMIENTO';
        $declarationNew->establishment_id  = $user_establishment->establishment_id;
        $declarationNew->user_id           = $user->id;

        $declarationNew->save(); 

        WasteDetail::where('declaration_id',$declarationNew->id)->delete();
  
        return response()->json($declarationNew);
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
