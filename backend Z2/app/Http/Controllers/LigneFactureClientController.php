<?php

namespace App\Http\Controllers;

use App\LigneFactureClient;
use App\LigneFactureProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LigneFactureClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return LigneFactureClient::all();
    }

    public function indexLigneFacture($idFacture)
    {

        // return LigneFactureProvider::where('FactureID', '=', $idFacture)->get();
        // $data=LigneFactureProvider::where('FactureID', '=', $idFacture)->join('Produits', 'ligne_facture_providers.ProduitsID', '=', 'produits.id')->select('Produits.*','ligne_facture_providers.*')->get();
        // $desc=preg_replace('/[\r\n]+/','',$data[0]->DescriptionProduit);
        // var_dump($desc);

        return LigneFactureClient::where('FactureID', '=', $idFacture)->join('Produits', 'ligne_facture_clients.ProduitsID', '=', 'produits.id')->select('Produits.*', 'ligne_facture_clients.*')->get();
    }



    public function indexLigneFactureIntervention($idFacture)
    {

        return DB::table('ligne_facture_interventions')->where('ligne_facture_interventions.FactureID', '=' , $idFacture)
            ->join('details_intervention', 'ligne_facture_interventions.DetailInterventionID', '=', 'details_intervention.id')
            ->join('vehicles', 'details_intervention.id_vehicule', '=', 'vehicles.id')
            ->join('products', 'ligne_facture_interventions.ProductID', '=', 'products.id')
            ->join('movements', 'products.movement_id', '=', 'movements.id')
            ->join('categories', 'movements.category_id', '=', 'categories.id')
            ->join('produits', 'movements.plan', 'like', 'produits.NomProduit')
            ->select('ligne_facture_interventions.*','details_intervention.*','products.*','vehicles.*','movements.*','categories.*','produits.*','ligne_facture_interventions.id')
            ->get();

    }


    function FactureMontant($id){

        $ligneFactureAll =  DB::table('ligne_facture_interventions')->where('ligne_facture_interventions.FactureID', '=' , $id)
            ->join('details_intervention', 'ligne_facture_interventions.DetailInterventionID', '=', 'details_intervention.id')
            ->join('products', 'ligne_facture_interventions.ProductID', '=', 'products.id')
            ->join('movements', 'products.movement_id', '=', 'movements.id')
            ->join('categories', 'movements.category_id', '=', 'categories.id')
            ->join('produits', 'movements.plan', 'like', 'produits.NomProduit')
            ->select(DB::raw('SUM(PUHT) as MHT'),DB::raw('SUM(PUHT*TVA)/100 as MTVA'),DB::raw('SUM(PUHT*Reducation)/100 as MR'))->get();


       $lignecalculer= $ligneFactureAll[0];


      $MontantTTC= $lignecalculer->MHT + $lignecalculer->MTVA - $lignecalculer->MR ;
      if ($MontantTTC==0){

         DB::update("update facture_clients set EtatFacture = 1 where id =$id");
         if( $facture = DB::update("update facture_clients set MontantHT =0, MontantTVA =0 , MontantTTC =  0  where id =$id")){
             return response()->json($facture, 201);
         }else
             return response()->json(['data'=>'error in the update'], 500);

       }else{

           DB::update("update facture_clients set EtatFacture = 1 where id =$id");
           if( $facture = DB::update("update facture_clients set MontantHT = $lignecalculer->MHT , MontantTVA = $lignecalculer->MTVA , MontantTTC =  $MontantTTC  where id =$id")){
               return response()->json($facture, 201);
           }else
               return response()->json(['data'=>'error in the update'], 500);



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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($ligneFacture = LigneFactureClient::create($request->all())) {
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
    public function show(LigneFactureClient $ligneFactureClient)
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
    public function update(Request $request)
    {

        $id = $request->input('id');
        $Reducation = $request->input('Reducation');
        $StartDateSIM = $request->input('StartDateSIM');
        $EndDateSIM =   $request->input('EndDateSIM');
        $PUHT =   $request->input('PUHT');
        $TVA =   $request->input('TVA');
        $PrixParMois =   $request->input('PrixParMois');
        $DescriptionFactureLigne =   $request->input('DescriptionFactureLigne');
        if($PrixParMois==''){
            $PrixParMois=0;
        }

        Log::info($request);

        if($request->input('StartDateSIM') != ''){
            if( $facture = DB::update("update ligne_facture_interventions set Reducation = $Reducation, StartDateSIM = '$StartDateSIM'  , EndDateSIM = '$EndDateSIM', PUHT = '$PUHT', TVA = '$TVA', PrixParMois = '$PrixParMois', DescriptionFactureLigne = '$DescriptionFactureLigne' where id =$id")){
                return response()->json($facture, 201);
            }else
                return response()->json(['data'=>'error in the update'], 500);

        }else{


            if( $facture = DB::update("update ligne_facture_interventions set Reducation = $Reducation, StartDateSIM = null  , EndDateSIM = null , PUHT = '$PUHT', TVA = '$TVA', PrixParMois = '$PrixParMois', DescriptionFactureLigne = '$DescriptionFactureLigne' where id =$id")){
                return response()->json($facture, 201);
            }else
                return response()->json(['data'=>'error in the update'], 500);
        }




    }


    public function destroy($idligneFacture)
    {
        if ($factureligne = LigneFactureClient::find($idligneFacture)) {
            $factureligne->delete();
            return response()->json(null, 202);
        } else
            return response()->json(['data' => 'error in the delete'], 500);
    }
}
