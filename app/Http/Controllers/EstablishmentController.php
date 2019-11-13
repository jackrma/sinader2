<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserEstablishment;

class EstablishmentController extends Controller
{


	public function data(Request $request){
		$user = Auth::user();
		$ue = UserEstablishment::where('user_id', $user->id)->first();  

		return response()->json($ue->establishment);
	}


    public function update(Request $request)
    {
    	return response()->json(['ok' => true, 'message' => "Establecimiento Actualizado" ]);
    }
}