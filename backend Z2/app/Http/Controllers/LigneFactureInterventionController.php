<?php

namespace App\Http\Controllers;

use App\LigneFactureIntervention;
use Illuminate\Http\Request;

class LigneFactureInterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\LigneFactureIntervention  $ligneFactureIntervention
     * @return \Illuminate\Http\Response
     */
    public function show(LigneFactureIntervention $ligneFactureIntervention)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LigneFactureIntervention  $ligneFactureIntervention
     * @return \Illuminate\Http\Response
     */
    public function edit(LigneFactureIntervention $ligneFactureIntervention)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LigneFactureIntervention  $ligneFactureIntervention
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $lignefactureUpdate = LigneFactureIntervention::findOrFail($request->input('id'));
        if($lignefacture = $lignefactureUpdate->update($request->all()))
        {
            return response()->json($lignefacture, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);



    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LigneFactureIntervention  $ligneFactureIntervention
     * @return \Illuminate\Http\Response
     */
    public function destroy(LigneFactureIntervention $ligneFactureIntervention)
    {
        //
    }
}
