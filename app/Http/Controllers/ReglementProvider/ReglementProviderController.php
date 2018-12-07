<?php

namespace App\Http\Controllers;

use App\ReglementProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReglementProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReglementProvider::orderBy('created_at', 'desc')->get();
    }


    public function indexFactureProvider($id){

        return ReglementProvider::where('FactureID', '=', $id)->get();
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

        $ID=$request->input('BanqueID');
        $MontantSolde = DB::select("SELECT *  From Banques WHERE id = $ID");
        $MS=$MontantSolde[0];
        $MontantSoldeT = $MS->Solde-$request->input('Montant');

        $compte=DB::update("update Banques set Solde = $MontantSoldeT where id =$ID");

        if($reglement = ReglementProvider::create($request->all()))
        {
            return response()->json($reglement, 201);
        }else
            return response()->json(['data'=>'error in the insert'], 500);

    }


    function ReglementFacture($id){

        $MontantR = DB::select("SELECT SUM(Montant) MR From reglement_providers WHERE FactureID =$id");
        $MontantR = $MontantR[0];
        $reglementFacture = DB::update("update facture_providers set MontantReglement =$MontantR->MR where id =$id");
        $select = DB::select("SELECT *  FROM facture_providers WHERE id =$id");
        $select = $select[0];
        if($select->MontantTTC <= $select->MontantReglement){

            if( $reglement = DB::update("update facture_providers set EtatFacture = 3  where id =$id")){

                return response()->json($reglement, 201);
            }else
                return response()->json(['data'=>'error in the update'], 500);

        }

        DB::update("update facture_providers set EtatFacture = 2  where id =$id");

        if($reglementFacture){
            return response()->json($reglementFacture, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);


  }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReglementProvider  $reglementProvider
     * @return \Illuminate\Http\Response
     */
    public function show(ReglementProvider $reglementProvider)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReglementProvider  $reglementProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(ReglementProvider $reglementProvider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReglementProvider  $reglementProvider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReglementProvider $reglementProvider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReglementProvider  $reglementProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy($idReglement)
    {
        if( $reglement= ReglementProvider::find($idReglement))
        {
            $banqueID =$reglement['BanqueID'];
            $MontantSolde = DB::select("SELECT *  From Banques WHERE id = $banqueID");
            $MS=$MontantSolde[0];
            $MontantSoldeT = $MS->Solde+$reglement['Montant'];
            $compte=DB::update("update Banques set Solde = $MontantSoldeT where id =$banqueID");
            $reglement->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }
}
