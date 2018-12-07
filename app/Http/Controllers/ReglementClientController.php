<?php

namespace App\Http\Controllers;

use App\ReglementClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReglementClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReglementClient::select()->join('banques', 'reglement_clients.BanqueID', '=', 'banques.id')->orderBy('reglement_clients.created_at', 'desc')->get();
    }


    public function indexFactureProvider($id){

        return ReglementClient::where('FactureID', '=', $id)->get();
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
       $MontantSoldeT = $MS->Solde+$request->input('Montant');

       $compte=DB::update("update Banques set Solde = $MontantSoldeT where id =$ID");


      if($reglement = ReglementClient::create($request->all()))
      {
          return response()->json($reglement, 201);
      }else
          return response()->json(['data'=>'error in the insert'], 500);





    }
    public function search(Request $request)
    {
      // Log::info($request->filled('DateEcheance'));


        if($request->input('DateEcheance')!='' and $request->input('ModePaiement')!='' )
        {
            $reglement=ReglementClient::where(['ModePaiement'=> $request->input('ModePaiement')],['DateEcheance'=>  date('Y-m-d H:i:s', strtotime($request->input('DateEcheance')))])->orderBy('created_at', 'desc')->get();

        }

        if ($request->input('ModePaiement')!='') {
            $reglement=ReglementClient::where(['ModePaiement'=> $request->input('ModePaiement')])->orderBy('created_at', 'desc')->get();
        }
        if ($request->input('DateEcheance')!=''){
            $reglement=ReglementClient::where(['DateEcheance'=>  date('Y-m-d H:i:s', strtotime($request->input('DateEcheance')))])->orderBy('created_at', 'desc')->get();
        }
            return response()->json($reglement, 201);


    }



    function ReglementFacture($id){

        $MontantR = DB::select("SELECT SUM(Montant) MR From reglement_clients WHERE FactureID =$id");
        $MontantR = $MontantR[0];
        $reglementFacture = DB::update("update facture_clients set MontantReglement =$MontantR->MR where id =$id");
        $select = DB::select("SELECT *  FROM facture_clients WHERE id =$id");
        $select = $select[0];
        if($select->MontantTTC <= $select->MontantReglement){

            if( $reglement = DB::update("update facture_clients set EtatFacture = 3  where id =$id")){

                return response()->json($reglement, 201);
            }else
                return response()->json(['data'=>'error in the update'], 500);

        }

        DB::update("update facture_clients set EtatFacture = 2  where id =$id");

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
    public function show(ReglementClient $reglementClient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReglementProvider  $reglementProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(ReglementClient $reglementClient)
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
    public function update(Request $request, ReglementClient $reglementClient)
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
        if( $reglement= ReglementClient::find($idReglement))
        {
            $banqueID =$reglement['BanqueID'];
            $MontantSolde = DB::select("SELECT *  From Banques WHERE id = $banqueID");
            $MS=$MontantSolde[0];
            $MontantSoldeT = $MS->Solde-$reglement['Montant'];
            $compte=DB::update("update Banques set Solde = $MontantSoldeT where id =$banqueID");
            $reglement->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }

}
