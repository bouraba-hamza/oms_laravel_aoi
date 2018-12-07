<?php

namespace App\Http\Controllers;

use App\FactureDetailIntervention;
use App\Models\Interventiondetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FactureDetailInterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('details_intervention')->where('details_intervention.EtatFacturation', '!=' , 1)
            ->join('interevention', 'details_intervention.id_intervention', '=', 'interevention.id')
            ->join('vehicles', 'details_intervention.id_vehicule', '=', 'vehicles.id')
            ->join('costumers', 'vehicles.costumer_id', '=', 'costumers.id')
            ->select('details_intervention.*','interevention.*','vehicles.*','costumers.*','details_intervention.id')
            ->get();
    }

    public function checkedIntervention(Request $request){

        $checked = $request->all();


        $fakture=DB::select("SELECT * FROM facture_clients ORDER BY id DESC");
        $devisFakture = $fakture[0];




        for ($v = 0; $v < count($checked); ++$v) {
            $lignecheck = $checked[$v];
            $detail = DB::select("SELECT * FROM details_intervention  where id = $lignecheck ");
            $detailIntervention =$detail[0];



            if($detailIntervention->imei_boitier != null){



                $infoProduit = DB::table('details_intervention')
                    ->join('products', 'details_intervention.imei_boitier', '=', 'products.id')
                    ->join('movements', 'products.movement_id', '=', 'movements.id')
                    ->join('categories', 'movements.category_id', '=', 'categories.id')
                    ->join('produits', 'movements.plan', 'like', 'produits.NomProduit')
                    ->select('details_intervention.*','products.*','movements.*','categories.*','produits.*','details_intervention.id')
                    ->get();

                $infoProduits = $infoProduit[0];


                DB::table('ligne_facture_interventions')->insert(
                    ['DetailInterventionID' => $lignecheck, 'FactureID' => $devisFakture->id,'ProductID'=> $detailIntervention->imei_boitier,'PUHT'=> $infoProduits->PrixVente,'TVA'=> $infoProduits->TauxTVA,'DescriptionFacture'=> $infoProduits->DescriptionFactureLigne ]
                );

            }


            if($detailIntervention->imei_carte != null){

                $infocarte = DB::table('details_intervention')
                    ->join('products', 'details_intervention.imei_carte', '=', 'products.id')
                    ->join('movements', 'products.movement_id', '=', 'movements.id')
                    ->join('categories', 'movements.category_id', '=', 'categories.id')
                    ->join('produits', 'movements.plan', 'like', 'produits.NomProduit')
                    ->select('details_intervention.*','products.*','movements.*','categories.*','produits.*','details_intervention.id')
                    ->get();

                $infoCProduits = $infocarte[0];

                DB::table('ligne_facture_interventions')->insert(
                    ['DetailInterventionID' => $lignecheck, 'FactureID' => $devisFakture->id,'ProductID'=> $detailIntervention->imei_carte,'PUHT'=> $infoCProduits->PrixVente,'TVA'=> $infoCProduits->TauxTVA,'DescriptionFacture'=> $infoCProduits->DescriptionFactureLigne]
                );

            }

            DB::table('details_intervention')->where('id', $lignecheck)->update(
                ['EtatFacturation' => 1]
            );





        }


    }
    public function checkedInterventionexiste(Request $request,$idfacture){

        $checked = $request->all();


        $fakture=DB::select("SELECT * FROM facture_clients where id = $idfacture");
        $devisFakture = $fakture[0];


        for ($v = 0; $v < count($checked); ++$v) {
            $lignecheck = $checked[$v];
            $detail = DB::select("SELECT * FROM details_intervention  where id = $lignecheck ");
            $detailIntervention =$detail[0];

            if($detailIntervention->imei_boitier != null){

                $infoProduit = DB::table('details_intervention')
                    ->join('products', 'details_intervention.imei_boitier', '=', 'products.id')
                    ->join('movements', 'products.movement_id', '=', 'movements.id')
                    ->join('categories', 'movements.category_id', '=', 'categories.id')
                    ->join('produits', 'movements.plan', 'like', 'produits.NomProduit')
                    ->select('details_intervention.*','products.*','movements.*','categories.*','produits.*','details_intervention.id')
                    ->get();

                $infoProduits = $infoProduit[0];


                DB::table('ligne_facture_interventions')->insert(
                    ['DetailInterventionID' => $lignecheck, 'FactureID' => $devisFakture->id,'ProductID'=> $detailIntervention->imei_boitier,'PUHT'=> $infoProduits->PrixVente,'TVA'=> $infoProduits->TauxTVA,'DescriptionFacture'=> $infoProduits->DescriptionFactureLigne ]
                );
            }


            if($detailIntervention->imei_carte != null){

                $infocarte = DB::table('details_intervention')
                    ->join('products', 'details_intervention.imei_carte', '=', 'products.id')
                    ->join('movements', 'products.movement_id', '=', 'movements.id')
                    ->join('categories', 'movements.category_id', '=', 'categories.id')
                    ->join('produits', 'movements.plan', 'like', 'produits.NomProduit')
                    ->select('details_intervention.*','products.*','movements.*','categories.*','produits.*','details_intervention.id')
                    ->get();

                $infoCProduits = $infocarte[0];

                DB::table('ligne_facture_interventions')->insert(
                    ['DetailInterventionID' => $lignecheck, 'FactureID' => $devisFakture->id,'ProductID'=> $detailIntervention->imei_carte,'PUHT'=> $infoCProduits->PrixVente,'TVA'=> $infoCProduits->TauxTVA,'DescriptionFacture'=> $infoCProduits->DescriptionFactureLigne]
                );

            }

            DB::table('details_intervention')->where('id', $lignecheck)->update(
                ['EtatFacturation' => 1]
            );





        }


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
     * @param  \App\FactureDetailIntervention  $factureDetailIntervention
     * @return \Illuminate\Http\Response
     */
    public function show(FactureDetailIntervention $factureDetailIntervention)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FactureDetailIntervention  $factureDetailIntervention
     * @return \Illuminate\Http\Response
     */
    public function edit(FactureDetailIntervention $factureDetailIntervention)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FactureDetailIntervention  $factureDetailIntervention
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FactureDetailIntervention $factureDetailIntervention)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FactureDetailIntervention  $factureDetailIntervention
     * @return \Illuminate\Http\Response
     */
    public function destroy(FactureDetailIntervention $factureDetailIntervention)
    {
        //
    }
}
