<?php

namespace App\Http\Controllers;

use App\LerChapter;
use Illuminate\Http\Request;

class LerChapterController extends Controller
{
	public function data(Request $request){
		$lerChapter = LerChapter::all();
		return response()->json($lerChapter);
	}
}