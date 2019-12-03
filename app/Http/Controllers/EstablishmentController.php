<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserEstablishment;
use App\Establishment;

class EstablishmentController extends Controller
{


	public function data(Request $request){
		$user = Auth::user();
		$ue = UserEstablishment::where('user_id', $user->id)->get()->first();  

		$establishment = Establishment::where('id',$ue->establishment_id)->with('commune')->with('region')->get()->first();

		Info('******************');
		Info($establishment);
		Info('******************');

		return response()->json($establishment);
	}


    public function update(Request $request)
    {
    	return response()->json(['ok' => true, 'message' => "Establecimiento Actualizado" ]);
    }
}