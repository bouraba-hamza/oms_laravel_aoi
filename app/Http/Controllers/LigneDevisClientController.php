<?php

namespace App\Http\Controllers;

use App\LigneDevisClient;
use Illuminate\Http\Request;

class LigneDevisClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return LigneDevisClient::all();
    }

    public function indexLigneFacture($idFacture)
    {

        // return LigneFactureProvider::where('FactureID', '=', $idFacture)->get();
        // $data=LigneFactureProvider::where('FactureID', '=', $idFacture)->join('Produits', 'ligne_facture_providers.ProduitsID', '=', 'produits.id')->select('Produits.*','ligne_facture_providers.*')->get();
        // $desc=preg_replace('/[\r\n]+/','',$data[0]->DescriptionProduit);
        // var_dump($desc);

        return LigneDevisClient::where('FactureID', '=', $idFacture)->join('Produits', 'ligne_devis_clients.ProduitsID', '=', 'produits.id')->select('Produits.*', 'ligne_devis_clients.*')->get();
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($ligneFacture = LigneDevisClient::create($request->all())) {
            return response()->json($ligneFacture, 201);
        } else
            return response()->json(['data' => 'error in the insert'], 500);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LigneFactureProvider $ligneFactureProvider
     * @return \Illuminate\Http\Response
     */
    public function show(LigneDevisClient $ligneFactureClient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LigneFactureProvider $ligneFactureProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(LigneFactureClient $ligneFactureClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\LigneFactureProvider $ligneFactureProvider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LigneDevisClient $lignedevisClient)
    {

    }


    public function destroy($idligneFacture)
    {
        if ($factureligne = LigneDevisClient::find($idligneFacture)) {
            $factureligne->delete();
            return response()->json(null, 202);
        } else
            return response()->json(['data' => 'error in the delete'], 500);
    }
}
