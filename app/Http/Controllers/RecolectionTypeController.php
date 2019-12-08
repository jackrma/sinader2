<?php

namespace App\Http\Controllers;

use App\RecolectionType;
use Illuminate\Http\Request;

class RecolectionTypeController extends Controller
{
	public function data(Request $request){
		$recolectionType = RecolectionType::all();
		return response()->json($recolectionType);
	}
}