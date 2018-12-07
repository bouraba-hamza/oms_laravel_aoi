<?php

namespace App\Http\Controllers;

use App\Banque;
use Illuminate\Http\Request;

class BanqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return Banque::all();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($banque = Banque::create($request->all()))

        {

            return response()->json($banque, 201);
        }else
            return response()->json(['data'=>'error in the insert'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banque  $banque
     * @return \Illuminate\Http\Response
     */
    public function show(Banque $banque)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Banque  $banque
     * @return \Illuminate\Http\Response
     */
    public function edit(Banque $banque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banque  $banque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $compteUpdate = Banque::findOrFail($request->input('id'));
        if($compte = $compteUpdate->update($request->all()))
        {
            return response()->json($compte, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banque  $banque
     * @return \Illuminate\Http\Response
     */
    public function destroy($idCompte)
    {
        if( $Compte = Banque::find($idCompte))
        {
            $Compte->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }
}
