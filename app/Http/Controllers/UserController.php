<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function update(Request $request)
    {
    	return response()->json(['ok' => true, 'message' => "Usuario Actualizada" ]);
    }

	public function data(Request $request){
		$user = Auth::user();	
		return response()->json($user);
	}
}