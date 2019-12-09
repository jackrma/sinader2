<?php

namespace App\Http\Controllers;

use App\Carrier;
use Illuminate\Http\Request;

class CarrierController extends Controller
{
	public function data(Request $request){
		$carrier = Carrier::all();
		return response()->json($carrier);
	}
}