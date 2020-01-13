<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserEstablishment;
use App\Establishment;

class EstablishmentController extends Controller
{


	public function index($company_id){
		$establishment = Establishment::where('company_id', $company_id)->where('type', 'DestinatarioFinal')->orWhere('type', 'CentroAcopio')->get();
		return response()->json($establishment);
	}

	public function data(Request $request){
		$user = Auth::user();
		$ue = UserEstablishment::where('user_id', $user->id)->get()->first();  

		$establishment = Establishment::where('id',$ue->establishment_id)->with('commune')->with('region')->get()->first();


		return response()->json($establishment);
	}

	public function forid($id){
		$establishment = Establishment::where('id', $id)->get()->first();
		return response()->json($establishment);
	}



    public function update(Request $request)
    {
    	return response()->json(['ok' => true, 'message' => "Establecimiento Actualizado" ]);
    }

	public function AllData($type){

		$establishment = Establishment::where('type',$type)->with('company')->with('commune')->with('region')->get();


		return response()->json($establishment);
	}    
}