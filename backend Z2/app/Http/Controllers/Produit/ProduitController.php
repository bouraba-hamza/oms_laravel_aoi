<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produit\StoreRequest;
use App\produit;
use App\Services\ProduitService;
use Illuminate\Http\Request;

class ProduitController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            return produit::where('TypeProduit', '=', 'B')->orderBy('created_at', 'desc')->get();
    }

    public function indexService(Request $request){
             return produit::where('TypeProduit','=','S')->orderBy('created_at', 'desc')->get();
    }

    public function select(Request $request)
    {
        return produit::where(['type'=>1,'EtatVente'=>0])->orderBy('created_at', 'desc')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
             //produit::create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($produit = Produit::create($request->all()))
       {
        return response()->json($produit, 201);
        }else
            return response()->json(['data'=>'error in the insert'], 500);

        //calcule montant

    }


    public function updateProduit($idProduit)
    {
        if($produit = Produit::find($idProduit))
        {
            $produit->update(['EtatAchat' => 1,'EtatVente' => 1]);


            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(produit $produit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $produitUpdate = produit::findOrFail($request->input('id'));
        if($produit = $produitUpdate->update($request->all()))
        {
            return response()->json($produit, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy($idProduit)
    {
        if($produit = Produit::find($idProduit))
        {
            $produit->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }
}
