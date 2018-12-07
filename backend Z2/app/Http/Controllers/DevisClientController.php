<?php

namespace App\Http\Controllers;

use App\DevisClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DevisClientController extends Controller
{
    public function index()
    {
        //return FactureProvider::all();
        return DevisClient::where('ClientID', '>', -1)->orderBy('devis_clients.created_at', 'desc')->join('costumers', 'devis_clients.ClientID', '=', 'costumers.id')->select('devis_clients.*','costumers.*','devis_clients.id')->get();
    }

    public function getFacture($id){

        return DevisClient::where('devis_clients.id', '=', $id)->join('costumers', 'devis_clients.ClientID', '=', 'costumers.id')->select('devis_clients.*','costumers.*','devis_clients.id')->get();

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
        if($facture = DevisClient::create($request->all()))
        {
            return response()->json($facture, 201);
        }else
            return response()->json(['data'=>'error in the insert'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FactureProvider  $factureProvider
     * @return \Illuminate\Http\Response
     */
    public function show(DevisClient $factureClient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FactureProvider  $factureProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(DevisClient $factureClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FactureProvider  $factureProvider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $factureUpdate = DevisClient::findOrFail($request->input('id'));
        if($facture = $factureUpdate->update($request->all()))
        {
            return response()->json($facture, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);



    }



    function FactureMontant($id){

        $MontantHT = DB::select("SELECT SUM(PUHT*Qte) MHT From ligne_devis_clients WHERE FactureID =$id");
        $MontantTVA = DB::select("SELECT SUM(PUHT*TVA*Qte)/100 MTVA FROM ligne_devis_clients WHERE FactureID =$id");
        $MontantReducation =DB::select("SELECT SUM(PUHT*Qte*Reducation)/100 MR FROM ligne_devis_clients WHERE FactureID =$id");

        $MTVA = $MontantTVA[0];
        $MHT = $MontantHT[0];
        $MR = $MontantReducation[0];

        $MontantTTC= $MHT->MHT + $MTVA->MTVA - $MR->MR ;
        if ($MontantTTC==0){

            DB::update("update devis_clients set EtatFacture = 0 where id =$id");
            if( $facture = DB::update("update devis_clients set MontantHT =0, MontantTVA =0 , MontantTTC =  0  where id =$id")){
                return response()->json($facture, 201);
            }else
                return response()->json(['data'=>'error in the update'], 500);

        }else{

            DB::update("update devis_clients set EtatFacture = 0 where id =$id");
            if( $facture = DB::update("update devis_clients set MontantHT = $MHT->MHT , MontantTVA = $MTVA->MTVA , MontantTTC =  $MontantTTC  where id =$id")){
                return response()->json($facture, 201);
            }else
                return response()->json(['data'=>'error in the update'], 500);



        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FactureProvider  $factureProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy($idFacture)
    {
        if( $facture = DevisClient::find($idFacture))
        {
            $facture->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }


    public function facture($idFacture)
    {
        $devis=DB::select("SELECT * FROM devis_clients where id = $idFacture");

       $devisFacture = $devis[0];

       $inserted=DB::insert("INSERT INTO facture_clients (MontantHT,MontantTVA,MontantTTC,NotePublic,NotePriver,EtatFacture,DateFacture,DateEcheance,MontantReglement,FactureIntervention,ClientID,created_at,updated_at)
                                        VALUES ($devisFacture->MontantHT,$devisFacture->MontantTVA,$devisFacture->MontantTTC,'$devisFacture->NotePublic','$devisFacture->NotePriver',1,NOW(),NOW(),0,0,$devisFacture->ClientID,NOW(),NOW())");
        log::info( $inserted);
        $fakture=DB::select("SELECT * FROM facture_clients ORDER BY id DESC");
        $devisFakture = $fakture[0];
        Log::info($devisFakture->id);

      $ligneDevis = DB::select("SELECT * FROM ligne_devis_clients where FactureID = $idFacture");
      foreach($ligneDevis as $key => $value) {
          $lignedevisFacture = $ligneDevis[$key];

          $inserted=DB::insert("INSERT INTO ligne_facture_clients (TVA,PUHT,Qte,Reducation,ProduitsID,FactureID,created_at,updated_at)
                                      VALUES ($lignedevisFacture->TVA,$lignedevisFacture->PUHT,$lignedevisFacture->Qte,$lignedevisFacture->Reducation,$lignedevisFacture->ProduitsID,$devisFakture->id,NOW(),NOW())");


      }


     if($facture =DB::update("update devis_clients set EtatFacture = 1 where id = $idFacture"))
     {
         return response()->json($facture, 202);
     }else
         return response()->json(['data'=>'error in the update'], 500);

    }
}
