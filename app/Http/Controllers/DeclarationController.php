<?php

namespace App\Http\Controllers;

use App\Declaration;
use App\User;
use App\UserEstablishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DeclarationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $declarations = Declaration::all();
        return response()->json($declarations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        Info('***************');
        Info('Declaration');
        Info('***************');


        $user = Auth::user();
        $user_establishment = UserEstablishment::where('user_id', $user->id)->first();

        Info($user_establishment);

        $declaration = new Declaration();

        $declaration->correlative       = '201901';
        $declaration->correlative_dv    = '2';
        $declaration->establishment_id  = $user_establishment->establishment_id;
        $declaration->user_id           = $user->id;   
        $declaration->carrier_id        = 0;
        $declaration->receiver_id       = 0;
        $declaration->type              = 'D.S.N°1/2013 MMA (Anual)';
        $declaration->period            =  2019;
        $declaration->status            = 'CREADA';

        $declaration->save();

        return response()->json($declaration);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function show(Declaration $declaration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function edit(Declaration $declaration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Declaration $declaration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Declaration  $declaration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Declaration $declaration)
    {
        //
    }
    
    public function pdf()
    {        

        // $pdf = PDF::loadView('Declaration', compact('declaration'));

        // return $pdf->download('Declaracion.pdf');
    }
}
