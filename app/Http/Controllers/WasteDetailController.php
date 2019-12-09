<?php

namespace App\Http\Controllers;

use App\WasteDetail;
use Illuminate\Http\Request;

class WasteDetailController extends Controller
{
 
    
    public function index($declaration_id)
    {

        $waste_details = WasteDetail::where('declaration_id', $declaration_id)->get();

		return response()->json($waste_details);
    }

    
}