<?php

namespace App\Http\Controllers;

use App\LerWaste;
use Illuminate\Http\Request;

class LerWasteController extends Controller
{

	public function data($lersubchapter_id){
		$lerWaste = LerWaste::where('subchapter_id', $lersubchapter_id)->get();
		return response()->json($lerWaste);
	}

	public function forid($id){
		$lerWaste = LerWaste::where('id', $id)->with('subchapter')->get()->first();
		return response()->json($lerWaste);
	}

}