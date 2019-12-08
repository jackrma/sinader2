<?php

namespace App\Http\Controllers;

use App\ManageType;
use Illuminate\Http\Request;

class ManageTypeController extends Controller
{
	public function data(Request $request){
		$manageType = ManageType::all();
		return response()->json($manageType);
	}
}