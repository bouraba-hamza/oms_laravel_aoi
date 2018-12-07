<?php

namespace App\Http\Controllers;

use App\LigneFactureProvider;
use Illuminate\Http\Request;

class LigneFactureProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return LigneFactureProvider::all();
    }

    public function indexLigneFacture($idFacture){

      // return LigneFactureProvider::where('FactureID', '=', $idFacture)->get();
       // $data=LigneFactureProvider::where('FactureID', '=', $idFacture)->join('Produits', 'ligne_facture_providers.ProduitsID', '=', 'produits.id')->select('Produits.*','ligne_facture_providers.*')->get();
       // $desc=preg_replace('/[\r\n]+/','',$data[0]->DescriptionProduit);
       // var_dump($desc);

        return LigneFactureProvider::where('FactureID', '=', $idFacture)->join('Produits', 'ligne_facture_providers.ProduitsID', '=', 'produits.id')->select('Produits.*','ligne_facture_providers.*')->get();
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

        if($ligneFacture = LigneFactureProvider::create($request->all()))
        {
            return response()->json($ligneFacture, 201);
        }else
            return response()->json(['data'=>'error in the insert'], 500);


    }
    /**
     * Display the specified resource.
     *
     * @param  \App\LigneFactureProvider  $ligneFactureProvider
     * @return \Illuminate\Http\Response
     */
    public function show(LigneFactureProvider $ligneFactureProvider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LigneFactureProvider  $ligneFactureProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(LigneFactureProvider $ligneFactureProvider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LigneFactureProvider  $ligneFactureProvider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LigneFactureProvider $ligneFactureProvider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LigneFactureProvider  $ligneFactureProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy($idligneFacture)
    {
        if ($factureligne = LigneFactureProvider::find($idligneFacture)) {
            $factureligne->delete();
            return response()->json(null, 202);
        } else
            return response()->json(['data' => 'error in the delete'], 500);
    }
}
