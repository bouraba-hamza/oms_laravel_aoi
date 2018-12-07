<?php

namespace App\Http\Controllers;

use App\FactureClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;

class FactureClientController extends Controller
{
    public function index()
    {
        //return FactureProvider::all();
        return FactureClient::where('FactureIntervention', '!=', 1)->orderBy('facture_clients.created_at', 'desc')->join('costumers', 'facture_clients.ClientID', '=', 'costumers.id')->select('facture_clients.*','costumers.*','facture_clients.id')->get();
    }

    public function indexIntervetion()
    {
        //return FactureProvider::all();
        return FactureClient::where('FactureIntervention', '=', 1)->orderBy('facture_clients.created_at', 'desc')->join('costumers', 'facture_clients.ClientID', '=', 'costumers.id')->select('facture_clients.*','costumers.*','facture_clients.id')->get();
    }


    public function getFacture($id){

        return FactureClient::where('facture_clients.id', '=', $id)->join('costumers', 'facture_clients.ClientID', '=', 'costumers.id')->select('facture_clients.*','costumers.*','facture_clients.id')->get();

    }


    public function getFactureExiste($id){

        return FactureClient::where('ClientID', '=', $id)->where('EtatFacture', '=', 1)->where('FactureIntervention', '=', 1)->get();

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
        if($facture = FactureClient::create($request->all()))
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
    public function toPdf($id){

        header('Access-Control-Allow-Origin: *');
        $factures = FactureClient::where('facture_clients.id', '=', $id)->join('costumers', 'facture_clients.ClientID', '=', 'costumers.id')->select('facture_clients.*','costumers.*','facture_clients.id')->get();
        $facture=$factures [0];

        $pdf = new Fpdi();
        $pdf->setSourceFile('images\Facture.pdf');
        $tplIdx = $pdf->importPage(1);
        $pdf->AddPage();
//Ref Facture client
        $pdf->useTemplate($tplIdx, 10, 10, 200);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(160, 30);
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Write(0,"Ref.        : FA".$facture['id']."-".$facture['id']);

//DAte Facture client

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(160, 33);
        $pdf->SetFont('Helvetica', 'B', 8);
        $dateFacture ="Date facturation :".substr($facture['DateFacture'],0,10);
        $pdf->Write(0,$dateFacture);


//DAte echeance client

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(160, 36);
        $pdf->SetFont('Helvetica', 'B', 8);
        $dateecheance ="Date echeance   :".substr($facture['DateEcheance'],0,10);
        $pdf->Write(0,$dateecheance);

 //Code client

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(160, 39);
        $pdf->SetFont('Helvetica', 'B', 8);
        $codeClient ="Code Client        :CU -".$facture['ClientID'];
        $pdf->Write(0,$codeClient);

//name client

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(110, 60);
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Write(0,$facture['name']);
//adress client
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(110, 65);
        $pdf->SetFont('Helvetica', 'B', 10);
        $address =$facture['address'];
        $pdf->Write(0,$address);
//adress client
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(110, 70);
        $pdf->SetFont('Helvetica', 'B', 10);
        $address1 = " Ville :" .$facture['city'];
        $pdf->Write(0,$address1);



//DESCRIPTION FACTURE






        $idFacture = $facture['id'];
        $ligneFacture=DB::select("SELECT * FROM ligne_facture_clients INNER JOIN produits ON ligne_facture_clients.ProduitsID = produits.id WHERE  FactureID = $idFacture ORDER BY ligne_facture_clients.id DESC");


        $i=0;

        for ($v = 0; $v < count($ligneFacture); ++$v) {

            $ligne = $ligneFacture[$v];

            if($v != 0){

                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY(20, 110+$i);
                $pdf->SetFont('Helvetica', 'i', 10);
                $pdf->Write(0,".....................................................................................................................................................................................");

            }

            $pdf->SetTextColor(0, 0, 0);
            Log::info($i);
            $pdf->SetXY(20, 120+$i);
            $pdf->SetFont('Helvetica', 'i', 10);
            $pdf->Write(0,$ligne->NomProduit);

            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetXY(20, 123+$i);
            $pdf->SetFont('Helvetica', 'i', 6);
            $pdf->MultiCell(100,4,$ligne->DescriptionFacture);

            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetXY(130, 120+$i);
            $pdf->SetFont('Helvetica', 'i', 10);
            $pdf->Write(0,$ligne->TVA.' %');

             $pdf->SetTextColor(0, 0, 0);
             $pdf->SetXY(145, 120+$i);
             $pdf->SetFont('Helvetica', 'i', 10);
             $pdf->Write(0,number_format($ligne->PUHT,2));

             $pdf->SetTextColor(0, 0, 0);
             $pdf->SetXY(165, 120+$i);
             $pdf->SetFont('Helvetica', 'i', 10);
             $pdf->Write(0,$ligne->Qte);

             $pdf->SetTextColor(0, 0, 0);
             $pdf->SetXY(180, 120+$i);
             $pdf->SetFont('Helvetica', 'i', 10);
             $pdf->Write(0,number_format($ligne->PUHT*$ligne->Qte,2));

            $i=$i+30;



       }






//Total HT
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(185, 234);
        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->Write(0, number_format($facture['MontantHT'], 2));




//Total TVA
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(185, 238);
        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->Write(0,number_format($facture['MontantTVA'], 2));

//Total TTC
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(185, 242);
        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->Write(0,number_format($facture['MontantTTC'], 2));






        $pdf->output('mypdf.pdf','D');

        return response()->json(['id'=>'test'],201);
    }


    public function toPdfIntervention($id){

        header('Access-Control-Allow-Origin: *');
        $factures = FactureClient::where('facture_clients.id', '=', $id)->join('costumers', 'facture_clients.ClientID', '=', 'costumers.id')->select('facture_clients.*','costumers.*','facture_clients.id')->get();
        $facture=$factures [0];

        $pdf = new Fpdi();
        $pdf->setSourceFile('images\Facture.pdf');
        $tplIdx = $pdf->importPage(1);
        $pdf->AddPage();
//Ref Facture client
        $pdf->useTemplate($tplIdx, 10, 10, 200);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(160, 30);
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Write(0,"Ref.        : FA".$facture['id']."-".$facture['id']);

//DAte Facture client

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(160, 33);
        $pdf->SetFont('Helvetica', 'B', 8);
        $dateFacture ="Date facturation :".substr($facture['DateFacture'],0,10);
        $pdf->Write(0,$dateFacture);


//DAte echeance client

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(160, 36);
        $pdf->SetFont('Helvetica', 'B', 8);
        $dateecheance ="Date echeance   :".substr($facture['DateEcheance'],0,10);
        $pdf->Write(0,$dateecheance);

        //Code client

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(160, 39);
        $pdf->SetFont('Helvetica', 'B', 8);
        $codeClient ="Code Client        :CU -".$facture['ClientID'];
        $pdf->Write(0,$codeClient);

//name client

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(110, 60);
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Write(0,$facture['name']);
//adress client
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(110, 65);
        $pdf->SetFont('Helvetica', 'B', 10);
        $address =$facture['address'];
        $pdf->Write(0,$address);
//adress client
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(110, 70);
        $pdf->SetFont('Helvetica', 'B', 10);
        $address1 = " Ville :" .$facture['city'];
        $pdf->Write(0,$address1);



//DESCRIPTION FACTURE






        $idFacture = $facture['id'];
        $ligneFacture = DB::table('ligne_facture_interventions')->where('ligne_facture_interventions.FactureID', '=' , $idFacture)
            ->join('details_intervention', 'ligne_facture_interventions.DetailInterventionID', '=', 'details_intervention.id')
            ->join('vehicles', 'details_intervention.id_vehicule', '=', 'vehicles.id')
            ->join('products', 'ligne_facture_interventions.ProductID', '=', 'products.id')
            ->join('movements', 'products.movement_id', '=', 'movements.id')
            ->join('categories', 'movements.category_id', '=', 'categories.id')
            ->join('produits', 'movements.plan', 'like', 'produits.NomProduit')
            ->select( DB::raw('COUNT(*) as total'),'products.model')
            ->groupBy('products.model')->get();

        Log::info($ligneFacture);

        $i=0;
        $j=0;
        $k=0;

        $descript = DB::table('ligne_facture_interventions')->where('ligne_facture_interventions.FactureID', '=' , $idFacture)
            ->join('details_intervention', 'ligne_facture_interventions.DetailInterventionID', '=', 'details_intervention.id')
            ->join('vehicles', 'details_intervention.id_vehicule', '=', 'vehicles.id')
            ->join('products', 'ligne_facture_interventions.ProductID', '=', 'products.id')
            ->join('movements', 'products.movement_id', '=', 'movements.id')
            ->join('categories', 'movements.category_id', '=', 'categories.id')
            ->join('produits', 'movements.plan', 'like', 'produits.NomProduit')
            ->select('ligne_facture_interventions.*','details_intervention.*','products.*','vehicles.*','movements.*','categories.*','produits.*','ligne_facture_interventions.id')
            ->get();


        for ($v = 0; $v < count($ligneFacture); ++$v) {

            $ligne = $ligneFacture[$v];
           $produits=DB::select("SELECT * FROM produits where NomProduit = '$ligne->model'");
           $pro = $produits[0];

            if($v != 0){

                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY(20, 110+$i);
                $pdf->SetFont('Helvetica', 'i', 10);
                $pdf->Write(0,".....................................................................................................................................................................................");

            }







         $pdf->SetTextColor(0, 0, 0);
         $pdf->SetXY(20, 120+$i);
         $pdf->SetFont('Helvetica', 'i', 10);
         $pdf->Write(0,$ligne->model);

         $pdf->SetTextColor(0, 0, 0);
         $pdf->SetXY(20, 123+$i);
         $pdf->SetFont('Helvetica', 'i', 6);
         $pdf->MultiCell(100,4,$pro->DescriptionFacture);




            for ($z = 0; $z < $ligne->total; ++$z) {
                $descripts = $descript[$k];
                if($descripts->category_id == 1){

                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetXY(20+$j, 143+$i);
                    $pdf->SetFont('Helvetica', 'i', 8);
                    $pipo = $descripts->imei ." / ";
                    $pdf->MultiCell(100,4,$pipo);

                }else{

                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetXY(20+$j, 153+$i);
                    $pdf->SetFont('Helvetica', 'i', 8);
                    $pipo = "( DU ".$descripts->StartDateSIM." au ".$descripts->EndDateSIM.") / ";
                    $pdf->MultiCell(100,4,$pipo);

                }
                $k =$k+1;
                $j= $j+20;

            }
         $pdf->SetTextColor(0, 0, 0);
         $pdf->SetXY(130, 120+$i);
         $pdf->SetFont('Helvetica', 'i', 10);
         $pdf->Write(0,$pro->TauxTVA.' %');

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(145, 120+$i);
        $pdf->SetFont('Helvetica', 'i', 10);
        $pdf->Write(0,number_format($pro->PrixVente,2));

         $pdf->SetTextColor(0, 0, 0);
         $pdf->SetXY(165, 120+$i);
         $pdf->SetFont('Helvetica', 'i', 10);
         $pdf->Write(0,$ligne->total);

         $pdf->SetTextColor(0, 0, 0);
         $pdf->SetXY(180, 120+$i);
         $pdf->SetFont('Helvetica', 'i', 10);
         $pdf->Write(0,number_format($pro->PrixVente*$ligne->total,2));

            $i=$i+40;



        }






//Total HT
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(185, 234);
        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->Write(0, number_format($facture['MontantHT'], 2));




//Total TVA
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(185, 238);
        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->Write(0,number_format($facture['MontantTVA'], 2));

//Total TTC
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(185, 242);
        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->Write(0,number_format($facture['MontantTTC'], 2));






        $pdf->output('mypdf.pdf','D');

        return response()->json(['id'=>'test'],201);
    }










    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FactureProvider  $factureProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(FactureClient $factureClient)
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
      Log::info($request->all());
        $factureUpdate = FactureClient::findOrFail($request->input('id'));
        if($facture = $factureUpdate->update($request->all()))
        {
            return response()->json($facture, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);



    }



   function FactureMontant($id){

       $MontantHT = DB::select("SELECT SUM(PUHT*Qte) MHT From ligne_facture_clients WHERE FactureID =$id");
       $MontantTVA = DB::select("SELECT SUM(PUHT*TVA*Qte)/100 MTVA FROM ligne_facture_clients WHERE FactureID =$id");
       $MontantReducation =DB::select("SELECT SUM(PUHT*Qte*Reducation)/100 MR FROM ligne_facture_clients WHERE FactureID =$id");

       $MTVA = $MontantTVA[0];
       $MHT = $MontantHT[0];
       $MR = $MontantReducation[0];

       $MontantTTC= $MHT->MHT + $MTVA->MTVA - $MR->MR ;
        if ($MontantTTC==0){

            DB::update("update facture_clients set EtatFacture = 0 where id =$id");
            if( $facture = DB::update("update facture_clients set MontantHT =0, MontantTVA =0 , MontantTTC =  0  where id =$id")){
                return response()->json($facture, 201);
            }else
                return response()->json(['data'=>'error in the update'], 500);

            }else{

            DB::update("update facture_clients set EtatFacture = 1 where id =$id");
            if( $facture = DB::update("update facture_clients set MontantHT = $MHT->MHT , MontantTVA = $MTVA->MTVA , MontantTTC =  $MontantTTC  where id =$id")){
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
        if( $facture = FactureClient::find($idFacture))
        {
            $facture->delete();
            return response()->json(null, 202);
        }else
            return response()->json(['data'=>'error in the delete'], 500);
    }


    public function close($idFacture)
    {

        if($facture =DB::update("update facture_clients set EtatFacture = 3 where id = $idFacture"))
        {
            return response()->json($facture, 202);
        }else
            return response()->json(['data'=>'error in the update'], 500);

    }
}
