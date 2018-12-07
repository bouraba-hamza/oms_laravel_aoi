<?php

namespace App\Http\Controllers;

use App\FactureProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FactureProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return FactureProvider::all();
        return FactureProvider::where('ProviderID', '>', -1)->orderBy('facture_providers.created_at', 'desc')->join('providers', 'facture_providers.ProviderID', '=', 'providers.id')->select('facture_providers.*','providers.*','facture_providers.id')->get();
    }

    public function getFacture($id){

        return FactureProvider::where('facture_providers.id', '=', $id)->join('providers', 'facture_providers.ProviderID', '=', 'providers.id')->select('facture_providers.*','providers.*','facture_providers.id')->get();

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
        if($facture = FactureProvider::create($request->all()))
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
    public function show(FactureProvider $factureProvider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FactureProvider  $factureProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(FactureProvider $factureProvider)
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

        $factureUpdate = FactureProvider::findOrFail($request->input('id'));
        if($facture = $factureUpdate->update($request->all()))
        {
            return response()->json($facture, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);

    }

    function FactureMontant($id){

        $MontantHT = DB::select("SELECT SUM(PUHT*Qte) MHT From ligne_facture_providers WHERE FactureID =$id");
        $MontantTVA = DB::select("SELECT SUM(PUHT*TVA*Qte)/100 MTVA FROM ligne_facture_providers WHERE FactureID =$id");
        $MontantReducation =DB::select("SELECT SUM(PUHT*Qte*Reducation)/100 MR FROM ligne_facture_providers WHERE FactureID =$id");

        $MTVA = $MontantTVA[0];
        $MHT = $MontantHT[0];
        $MR = $MontantReducation[0];

        $MontantTTC= $MHT->MHT + $MTVA->MTVA - $MR->MR ;

        if ($MontantTTC==0){

            DB::update("update facture_providers set EtatFacture = 0 where id =$id");
            if( $facture = DB::update("update facture_providers set MontantHT =0, MontantTVA =0 , MontantTTC =  0  where id =$id")){
                return response()->json($facture, 201);
            }else
                return response()->json(['data'=>'error in the update'], 500);

        }else {
            DB::update("update facture_providers set EtatFacture = 1 where id =$id");
            if ($facture = DB::update("update facture_providers set MontantHT = $MHT->MHT , MontantTVA = $MTVA->MTVA , MontantTTC =  $MontantTTC  where id =$id")) {
                return response()->json($facture, 201);
            } else
                return response()->json(['data' => 'error in the update'], 500);
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
        if( $facture = FactureProvider::find($idFacture))
        {
            $facture->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }
}
