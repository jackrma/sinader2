<?php

namespace App\Http\Controllers;

use App\LerSubChapter;
use Illuminate\Http\Request;

class LerSubChapterController extends Controller
{

	public function data($lerchapter_id){

		$lerSubChapter = LerSubChapter::where('chapter_id', $lerchapter_id)->get();
		return response()->json($lerSubChapter);
	}
}