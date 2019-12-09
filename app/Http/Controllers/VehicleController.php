<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
	public function data($carrier_id){
		$vehicle = Vehicle::where('carrier_id', $carrier_id)->get();
		return response()->json($vehicle);
	}
}