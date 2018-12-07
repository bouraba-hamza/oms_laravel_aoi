<?php

namespace App\Http\Controllers\Intervention;
use App\Http\Controllers\Interventiondetail\InterventiondetailsController;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Costumer;
use App\Models\DetailsIntervention;
use App\Models\Interevention;
use App\Models\Intervention;
use App\Models\Personal;
use App\Models\Product;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;


class InterventionsController extends Controller
{



    public function index(Request $request)
    {

        $dataInterventions = DB::table('interevention')
            ->leftJoin('personals', 'personals.id', '=', 'interevention.id_instalateur')
            ->leftJoin('costumers', 'costumers.id', '=', 'interevention.id_costumer')
            ->orderBy('interevention.id', 'desc')
            ->select('interevention.id as intervention_id','interevention.*','personals.*','costumers.*')
            ->get();

        return $dataInterventions ;
    }


    public function filter(Request $request) {
        $data = $request->input('data');
        $column = $request->input('target');
        if ($data == ''){
            return DB::table('interevention')
                ->leftJoin('personals', 'personals.id', '=', 'interevention.id_instalateur')
                ->leftJoin('costumers', 'costumers.id', '=', 'interevention.id_costumer')
                ->orderBy('interevention.id', 'desc')
                ->select('interevention.id as intervention_id','interevention.*','personals.*','costumers.*')
                ->get();
        }
        $dataInterventions = DB::table('interevention')
            ->where('interevention.'.$column, 'like', '%'.$data.'%')
            ->leftJoin('personals', 'personals.id', '=', 'interevention.id_instalateur')
            ->leftJoin('costumers', 'costumers.id', '=', 'interevention.id_costumer')
            ->orderBy('interevention.id', 'desc')
            ->select('interevention.id as intervention_id','interevention.*','personals.*','costumers.*')
            ->get();
        Log::info($dataInterventions);
        return response()->json($dataInterventions,201);
    }


    public function store(Request $request) {
        $requestData = $request->all();

        $intervention=Intervention::create($requestData);
        return response()->json($intervention, 201);
    }


    public function bigJoin(Request $request){

        $dataInterventions=[];

        $intervention = intval($request->input('intervention'));
        $costumer = Interevention::findOrFail($intervention)->id_costumer;
        $installateur = Interevention::findOrFail($intervention)->id_instalateur;

        $categorie = $request->input('categorie');
        $type = $request->input('type');

        if($type == 'r' && $categorie == 2) {
            $dataInterventions = DB::table('products')
                ->where('inventory_personals.personal_id','=',$installateur)
                ->where('inventory_personals.status','<>','0')
                ->where('inventory_personals.status','<>','3')
                ->where('products.status','=','2')
                ->where('categories.id','=',2)
                ->join('inventory_personals','inventory_personals.product_id','=','products.id')
                ->join('movements','movements.id','=','products.movement_id')
                ->join('categories','categories.id','=','movements.category_id')
                ->select('products.label as product_label','products.id as product_id','products.*','inventory_personals.*','movements.*','categories.*')
                ->distinct()
                ->get();
        }

        if ($type == 'i'){
            $dataInterventions = DB::table('products')
                ->where('inventory_personals.personal_id','=',$installateur)
                ->where('inventory_personals.status','<>','0')
                ->where('inventory_personals.status','<>','3')
                ->where('products.status','=','2')
                ->where('categories.id','=',$categorie)
                ->join('inventory_personals','inventory_personals.product_id','=','products.id')
                ->join('movements','movements.id','=','products.movement_id')
                ->join('categories','categories.id','=','movements.category_id')
                ->select('products.label as product_label','products.id as product_id','products.*','inventory_personals.*','movements.*','categories.*')
                ->distinct()
                ->get();
        }else{
            if ($type == 'v' || $type == 'd' || ($type == 'r' && $categorie == 1)){
                $imei = $categorie == 1 ? 'imei_boitier': 'imei_carte';
                $dataInterventions = DB::table('products')
                    ->where('products.status','=','0')
                    ->where('interevention.id_costumer','=',$costumer)
                    ->where(DB::raw("details_intervention.type in ('i','cb','cs') or (details_intervention.type in ('r','v') and products.beforeOms = '1')"))
                    ->join('details_intervention','details_intervention.'.$imei,'=','products.id')
                    ->join('interevention','interevention.id','=','details_intervention.id_intervention')
                    ->select('products.label as product_label','products.id as product_id','products.*','details_intervention.*','interevention.*')
                    ->distinct()
                    ->get();
            }
            if ($type == 'cs') {
                $dataInterventions = DB::table('products')
                    ->where('products.status','=','0')
                    ->where('interevention.id_costumer','=',$costumer)
                    ->where(DB::raw("details_intervention.type in ('i','cb','cs') or (details_intervention.type in ('r','v') and products.beforeOms = '1')"))
                    ->join('details_intervention','details_intervention.imei_boitier','=','products.id')
                    ->join('interevention','interevention.id','=','details_intervention.id_intervention')
                    ->select('products.label as product_label','products.id as product_id','products.*','details_intervention.*','interevention.*')
                    ->distinct()
                    ->get();
            }
            if ($type == 'cb') {
                $dataInterventions = DB::table('products')
                    ->where('products.status','=','0')
                    ->where('interevention.id_costumer','=',$costumer)
                    ->where(DB::raw("details_intervention.type in ('i','cb','cs') or (details_intervention.type in ('r','v') and products.beforeOms = '1')"))
                    ->join('details_intervention','details_intervention.imei_carte','=','products.id')
                    ->join('interevention','interevention.id','=','details_intervention.id_intervention')
                    ->select('products.label as product_label','products.id as product_id','products.*','details_intervention.*','interevention.*')
                    ->distinct()
                    ->get();
            }
        }
        return response()->json($dataInterventions, 201);
    }


    public function getProduct($id_product,$categorie){
        if($id_product == '0' || $id_product == null)
            return null;
        else{
            if( $categorie == 1)
                return Product::findOrFail($id_product)->imei_product;
            else
                return Product::findOrFail($id_product)->label;
        }

    }


    public function getDetailIntervention(Request $request){
        $intervention = intval($request->input('id_intervention'));
        $dataInterventions = DB::table('details_intervention')
            ->where('details_intervention.id_intervention','=',$intervention)
            ->join('interevention','interevention.id','=','details_intervention.id_intervention')
            ->join('vehicles','vehicles.id','=','details_intervention.id_vehicule')
            ->select('details_intervention.imei_boitier as imei_cb_update','details_intervention.imei_boitier as label_cs_update','details_intervention.id as detail_id','details_intervention.imei_boitier as imei_product_boitier','details_intervention.imei_carte as imei_product_carte','details_intervention.remarque as remarque_detail','details_intervention.*','interevention.*','vehicles.*')
            ->orderBy('detail_id', 'desc')
            ->get();

        for ($v= 0 ; $v<count($dataInterventions); $v++){
            $dataInterventions[$v]->imei_product_boitier = $this->getProduct($dataInterventions[$v]->imei_boitier,1);
            $dataInterventions[$v]->imei_product_carte = $this->getProduct($dataInterventions[$v]->imei_carte,2);

            $dataInterventions[$v]->imei_cb_update = $this->getProduct($dataInterventions[$v]->oldChange,1);
            $dataInterventions[$v]->label_cs_update = $this->getProduct($dataInterventions[$v]->oldChange,2);
        }
        return response()->json($dataInterventions, 201);
    }



    public function edit(Request $request) {

        $customer_id   = intval($request->input('customer_id'));
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $invented_date = $request->input('date');

        $unique_id = str_replace(':','',$date = date('H:i:s'));

        $id=$request->input('intervention_id');

        $fake_name = $unique_id.'_'.$id;

        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $image=$file->getClientOriginalName();
            $unique_id = str_replace(':','',$date = date('H:i:s'));
            $fake_name = $fake_name.'_'.$image;
            $path = $request->file('photo')->storeAs(
                'images', $fake_name
            );
            DB::table('interevention')
                ->where('interevention.id','=', $id)
                ->update(['interevention.intervened_at' => $invented_date ,
                    'interevention.starthour' => $start_date ,
                    'interevention.endhour' => $end_date ,
                    'interevention.id_costumer' => $customer_id ,
                    'interevention.upload' => $fake_name
                ]);
        }
        else {
            DB::table('interevention')
                ->where('interevention.id','=', $id)
                ->update(['interevention.intervened_at' => $invented_date ,
                    'interevention.starthour' => $start_date ,
                    'interevention.endhour' => $end_date ,
                    'interevention.id_costumer' => $customer_id
                ]);
        }
        return response()->json([], 201);
    }


    public function update(Request $request) {
        $InterventionUpdate = Interevention::findOrFail($request->input('id_intervention'));
        if($Intervention = $InterventionUpdate->update($request->all()))
        {
            return response()->json($Intervention, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);
    }


    public function destroy($id) {
        $count_detail = DB::table('details_intervention')
            ->where('details_intervention.id_intervention','=',$id)
            ->count();

        if($count_detail <= 0) {
            if ($interevention = Interevention::find($id)) {
                $interevention->delete();
                return response()->json(null, 202);
            }else
                return response()->json(['data'=>'error in the delete'], 500);
        }
        else {
            return response()->json(['data'=>'error','status' =>203], 201);
        }
    }


    public function destroy_detail_intervention($id) {
        if(DB::table('details_intervention')->where('details_intervention.id', '=',$id)->delete())
            return response()->json(null, 202);
        return response()->json(['data'=>'error in the delete'], 202);
    }


    public function verify(Request $request){
        $installateur     = $request->input('id_installateur');
        $nbr_installation = $request->input('nbr_installation');

        $boitiers = DB::table('inventory_personals')
            ->where('movements.category_id', '=',1)
            ->where('inventory_personals.status', '=','1')
            ->where('inventory_personals.personal_id', '=' ,$installateur)
            ->join('products', 'products.id', '=', 'inventory_personals.product_id')
            ->join('movements', 'movements.id', '=', 'products.movement_id')
            ->count();

        $carteSim = DB::table('inventory_personals')
            ->where('movements.category_id', '=',2)
            ->where('inventory_personals.status', '=','1')
            ->where('inventory_personals.personal_id', '=' ,1)
            ->join('products', 'products.id', '=', 'inventory_personals.product_id')
            ->join('movements', 'movements.id', '=', 'products.movement_id')
            ->count();

        if ( $boitiers >= $nbr_installation  &&  $carteSim >= $nbr_installation ){

            if($intervention = Interevention::create($request->all()))
            {
                return response()->json($intervention, 201);
            }else
                return response()->json(['data'=>'error in the insert'], 500);
        }else{
            return response()->json(['data'=>"le nombre d'installation > aux boitiérs",'status' =>203 ], 203);
        }
    }


    public function toPdf($id){

        header('Access-Control-Allow-Origin: *');
        $pdf = new Fpdi();
        $pdf->setSourceFile('C:\wamp64\www\myapp\public\Pdf\fichedintervention.pdf');
        $tplIdx = $pdf->importPage(1);
        $pdf->AddPage();
        $pdf->useTemplate($tplIdx, 10, 10, 200);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Helvetica', 'B', 10);
        // Reference
        $installateur_id = Interevention::findOrFail($id)->id_instalateur;
        $intervention_date = Interevention::findOrFail($id)->intervened_at;
        if ($intervention_date !== NULL && $installateur_id !== 0){
            $ref = str_replace("-","",substr($intervention_date,2,8)).'-'.$installateur_id.'-'.$id;
            $pdf->SetXY(170, 24.5);
            $pdf->Write(0,$ref);
        }
        // Costumer name
        $costumer_id = Interevention::findOrFail($id)->id_costumer;
        if ($costumer_id !== 0 && $costumer_id !==NULL){
            $costumer_name = Costumer::findOrFail($costumer_id)->name;
            $costumer_email = Costumer::findOrFail($costumer_id)->mail;

            $pdf->SetXY(125, 45.5);
            $pdf->Write(0,$costumer_name);
            $pdf->SetXY(125, 64);
            $pdf->Write(0,$costumer_email);
        }
        // Date d'intervention
        if (Interevention::findOrFail($id)->intervened_at !== NULL){
            $intervened_at = substr(Interevention::findOrFail($id)->intervened_at,0,10);
            $pdf->SetXY(57, 82.5);
            $pdf->Write(0,$intervened_at);
        }
        // Heure de départ de l'intervention
        if (Interevention::findOrFail($id)->starthour !== NULL){
            $starthour = substr(Interevention::findOrFail($id)->starthour,0,5);
            $pdf->SetXY(105, 82.5);
            $pdf->Write(0,$starthour);
        }
        // Heure de fin de l'intervention
        if (Interevention::findOrFail($id)->endhour !== NULL) {
            $endhour = substr(Interevention::findOrFail($id)->endhour, 0, 5);
            $pdf->SetXY(145, 82.5);
            $pdf->Write(0, $endhour);
        }


        // Durée de l'intervention
        $sum_duration = DB::table('details_intervention')
            ->where('details_intervention.id_intervention',$id)
            ->select(DB::raw('SEC_TO_TIME( SUM( TIME_TO_SEC( `detail_endhour` ) - TIME_TO_SEC( `detail_starthour` ) ) ) as timeSum'))
            ->get();
        $pdf->SetXY(176, 82.5);
        $pdf->Write(0,$sum_duration[0]->timeSum);


        // Nom de l'intervenant
        $personal_id = Interevention::findOrFail($id)->id_instalateur;
        if ($personal_id !== NULL){
            $name = Personal::findOrFail($personal_id)->last_name.' '.Personal::findOrFail($personal_id)->first_name;
            $pdf->SetXY(57, 88);
            $pdf->Write(0,$name);
        }
        // Detail Intervention
        $details = DB::table('details_intervention')
            ->where('details_intervention.id_intervention',$id)
            ->get();
        for ($v= count($details)-1,$yc =0,$yh = 0,$y = 0; $v>=0; $v--){
            $box_costumer = $details[$v]->box_costumer;
            $imei_boitier = $details[$v]->imei_boitier;
            $sim_costumer = $details[$v]->sim_costumer;
            $imei_carte   = $details[$v]->imei_carte;
            $kilometrage = $details[$v]->kilometrage;
            $vehicule_id = $details[$v]->id_vehicule;
            $imei = Vehicle::findOrFail($vehicule_id)->imei;
            log::info($imei);
            $marque = Vehicle::findOrFail($vehicule_id)->marque;
            $model = Vehicle::findOrFail($vehicule_id)->modele;
            $starthour = $details[$v]->detail_starthour;
            $endhour = $details[$v]->detail_endhour;
            $pdf->SetFont('Helvetica', 'B', 8);
            // TYPE
            $type = $details[$v]->type;
            switch ($type){
                case 'i': $pdf->SetXY(21, 113.7+$y);break;
                case 'v': $pdf->SetXY(27.5, 113.7+$y);break;
                case 'cb': $pdf->SetXY(34.2, 113.7+$y);break;
                case 'd': $pdf->SetXY(21, 119.3+$y);break;
                case 'r': $pdf->SetXY(27.5, 119.3+$y);break;
                case 'cs': $pdf->SetXY(34.2, 119.3+$y);
            }
            $pdf->Write(0,'X');

            $pdf->SetXY(44, 115+$y);
            $pdf->Write(0,$marque);

            $pdf->SetXY(44, 119+$y);
            $pdf->Write(0,$model);

            $pdf->SetXY(60, 116+$y);
            $pdf->Write(0,$imei);

            $pdf->SetXY(80, 116+$y);
            $pdf->Write(0,$kilometrage);

            $pdf->SetXY(94, 115+$y);
            if($box_costumer == '0' || $box_costumer == NULL){
                $boitier = Product::findOrFail($imei_boitier)->imei_product;
                $pdf->Write(0,$boitier);
            }else{
                $pdf->Write(0,$box_costumer);
                $pdf->SetXY(93.5, 119+$y+$yc);
                $pdf->Write(0,'X');
            }

            $pdf->SetXY(120, 115+$y);
            if($box_costumer == '0' || $box_costumer == NULL){
                $boitier = Product::findOrFail($imei_boitier)->modele;
                $pdf->Write(0,$boitier);
            }

            $pdf->SetXY(140, 115+$y);
            if($sim_costumer == '0' || $sim_costumer == NULL){
                $carte = Product::findOrFail($imei_carte)->label;
                $pdf->Write(0,$carte);
            }else{
                $pdf->Write(0,$sim_costumer);
                $pdf->SetXY(139, 119+$y+$yc);
                $pdf->Write(0,'X');
            }

            $pdf->SetXY(190, 114+$y+$yh);
            $pdf->Write(0,substr($starthour,0,5));

            $pdf->SetXY(190, 118+$y+$yh);
            $pdf->Write(0,substr($endhour,0,5));

            $y+=10.5;
            $yc = $yc + 0.25;
            $yh = $yh + 0.2;
        }

        // Generation du PDF
        $pdf->output('fiche_intervention.pdf','D');

        return response()->json(['id'=>$id],201);
    }



    public function storeInStorage(Request $request){
        Log::info($request->all());
        $type = $request->input('type');
        $imei_boitier = $request->input('imei_boitier');
        $imei_carte = $request->input('imei_carte');
        Storage::put('detail_intervention.txt',$type.':'.$imei_boitier.':'.$imei_carte );
    }



    public function update_line(Request $request){
        Log::info($request->all());
        $id = intval($request->input('detail_id'));
        $intervention = intval($request->input('intervention'));
        $installateur = Interevention::findOrFail($intervention)->id_instalateur;
        $box_costumer = $request->input('box_costumer') == "0" ? NULL : $request->input('box_costumer');
        $sim_costumer = $request->input('sim_costumer') == "0" ? NULL : $request->input('sim_costumer');
        $imei_boitier = $request->input('imei_box') == NULL ? NULL : intval($request->input('imei_box'));
        $imei_carte   = $request->input('imei_sim') == NULL ? NULL : intval($request->input('imei_sim'));
        $kilometrage = $request->input('kilometrage');
        $remarque = $request->input('remarque');
        $type = $request->input('type');
        $detail_starthour = $request->input('starthour');
        $detail_endhour = $request->input('endhour');
        $vehicule = intval($request->input('vehicule'));
        $vehicule_id = $vehicule;
        $oldBoxCb = intval($request->input('oldBoxCb_update'));
        $newBoxCb = intval($request->input('newBoxCb_update'));
        $oldSimCs = intval($request->input('oldSimCs_update'));
        $newSimCs = intval($request->input('newSimCs_update'));


        if ($vehicule == NULL){
            $costumer = Interevention::findOrFail($intervention)->id_costumer;
            $user_id  = Interevention::findOrFail($intervention)->user_id;
            $vehicule_id = DB::table('vehicles')->insertGetId(
                [
                    'imei' => $request->input('imei'),
                    'marque' => $request->input('marque'),
                    'model' => $request->input('model') ,
                    'costumer_id' => $costumer ,
                    'user_id' => $user_id
                ]
            );
        }


        // Not Updated For type i or d
        $contents = Storage::get('detail_intervention.txt');
        $splitContents = explode(':',$contents);
        $old_box = intval($splitContents[1]);
        $old_sim = intval($splitContents[2]);
        if ($old_box != $imei_boitier) {
            if ($old_box != NULL) {
                if ($splitContents[0] == 'i'){
                    DB::table('inventory_personals')
                        ->where('product_id',$old_box)
                        ->update(['status' => '1']);
                    DB::table('products')
                        ->where('id',$old_box)
                        ->update(['status' => '2']);
                }
                if ($splitContents[0] == 'd'){
                    DB::table('inventory_personals')
                        ->where('product_id',$old_box)
                        ->update(['status' => '0']);
                    DB::table('products')
                        ->where('id',$old_box)
                        ->update(['status' => '0']);
                }
            }
        }
        if ($old_sim != $imei_carte) {
            if ($old_sim != NULL) {
                if ($splitContents[0] == 'i' || $splitContents[0] == 'r') {
                    DB::table('inventory_personals')
                        ->where('product_id',$old_sim)
                        ->update(['status' => '1']);
                    DB::table('products')
                        ->where('id',$old_sim)
                        ->update(['status' => '2']);
                }
                if ($splitContents[0] == 'd'){
                    DB::table('inventory_personals')
                        ->where('product_id',$old_sim)
                        ->update(['status' => '0']);
                    DB::table('products')
                        ->where('id',$old_sim)
                        ->update(['status' => '0']);
                }
            }
        }
        // END

        if($imei_boitier != null){
            if($type == 'i') {
                DB::table('inventory_personals')
                    ->where('product_id',$imei_boitier)
                    ->update(['status' => '0']);
                DB::table('products')
                    ->where('id',$imei_boitier)
                    ->update(['status' => '0']);
            }
            else {
                if($type == 'd') {
                    DB::table('inventory_personals')
                        ->where('product_id',$imei_boitier)
                        ->update(['status' => '1']);
                    DB::table('products')
                        ->where('id',$imei_boitier)
                        ->update(['status' => '2']);
                }
            }
        }
        if($imei_carte != null){
            if($type == 'i') {
                DB::table('inventory_personals')
                    ->where('product_id',$imei_carte)
                    ->update(['status' => '0']);
                DB::table('products')
                    ->where('id',$imei_carte)
                    ->update(['status' => '0']);
            }
            else {
                if($type == 'd') {
                    DB::table('inventory_personals')
                        ->where('product_id',$imei_carte)
                        ->update(['status' => '1']);
                    DB::table('products')
                        ->where('id',$imei_carte)
                        ->update(['status' => '2']);
                }elseif ($type == 'r'){
                    DB::table('inventory_personals')
                        ->where('product_id',$imei_carte)
                        ->update(['status' => '0']);
                    DB::table('products')
                        ->where('id',$imei_carte)
                        ->update(['status' => '0']);
                }
            }
        }

        $old_to_be_new = null;

        if ($type == 'cb') {
            $old = DetailsIntervention::findOrFail($intervention)->oldChange;
            if ($old != $oldBoxCb){
                DB::table('inventory_personals')
                    ->where('product_id',$old)
                    ->update(['status' => '0']);
                DB::table('products')
                    ->where('id',$old)
                    ->update(['status' => '0']);

                DB::table('inventory_personals')
                    ->where('product_id',$oldBoxCb)
                    ->update([
                        'status' => '2',
                        'personal_id' => $installateur
                    ]);
                DB::table('products')
                    ->where('id',$oldBoxCb)
                    ->update(['status' => '1']);
                $old_to_be_new = $oldBoxCb;
            }else{
                $old_to_be_new = $old;
            }

            $old = DetailsIntervention::findOrFail($intervention)->imei_boitier;
            if ($old != $newBoxCb){
                DB::table('inventory_personals')
                    ->where('product_id',$old)
                    ->update(['status' => '0']);
                DB::table('products')
                    ->where('id',$old)
                    ->update(['status' => '0']);

                DB::table('inventory_personals')
                    ->where('product_id',$newBoxCb)
                    ->update([
                        'status' => '2',
                        'personal_id' => $installateur
                    ]);
                DB::table('products')
                    ->where('id',$newBoxCb)
                    ->update(['status' => '1']);
                $imei_boitier = $newBoxCb;
            }else{
                $imei_boitier = $old;
            }
        }

        if ($type == 'cs') {
            $old = DetailsIntervention::findOrFail($intervention)->oldChange;
            if ($old != $oldSimCs){
                DB::table('inventory_personals')
                    ->where('product_id',$old)
                    ->update(['status' => '0']);
                DB::table('products')
                    ->where('id',$old)
                    ->update(['status' => '0']);

                DB::table('inventory_personals')
                    ->where('product_id',$oldSimCs)
                    ->update([
                        'status' => '2',
                        'personal_id' => $installateur
                    ]);
                DB::table('products')
                    ->where('id',$oldSimCs)
                    ->update(['status' => '1']);

                $old_to_be_new = $oldSimCs;
            }else{
                $old_to_be_new = $old;
            }

            $old = DetailsIntervention::findOrFail($intervention)->imei_carte;
            if ($old != $newSimCs){
                DB::table('inventory_personals')
                    ->where('product_id',$old)
                    ->update(['status' => '0']);
                DB::table('products')
                    ->where('id',$old)
                    ->update(['status' => '0']);

                DB::table('inventory_personals')
                    ->where('product_id',$newSimCs)
                    ->update([
                        'status' => '2',
                        'personal_id' => $installateur
                    ]);
                DB::table('products')
                    ->where('id',$newSimCs)
                    ->update(['status' => '1']);
                $imei_carte = $newSimCs;
            }else{
                $imei_carte = $old;
            }
        }

        DB::table('details_intervention')
            ->where('details_intervention.id',$id)
            ->update(
                [
                    'type'=>$type,
                    'id_vehicule'=>$vehicule_id,
                    'imei_boitier'=>$imei_boitier,
                    'imei_carte'=>$imei_carte,
                    'kilometrage'=>$kilometrage,
                    'remarque'=>$remarque,
                    'detail_starthour'=>$detail_starthour,
                    'detail_endhour'=>$detail_endhour,
                    'box_costumer'=>$box_costumer,
                    'sim_costumer'=>$sim_costumer,
                    'oldChange' => $old_to_be_new
                ]
            );
        return response()->json([],201);
    }



    public function add_detail (Request $request){
        $intervention = intval($request->input('intervention'));
        $installateur = Interevention::findOrFail($intervention)->id_instalateur;
        $type = $request->input('type');
        $vehicule = intval($request->input('vehicule'));

        $imei_boitier = $request->input('imei_box');
        $imei_carte   = $request->input('imei_sim');

        $box_costumer = $request->input('box_costumer');
        $sim_costumer = $request->input('sim_costumer');

        $kilometrage = $request->input('kilometrage');
        $remarque = $request->input('remarque');
        $detail_starthour = $request->input('starthour');
        $detail_endhour = $request->input('endhour');

        $vehicule_id = $vehicule;

        if ($vehicule == NULL){
            $costumer = Interevention::findOrFail($intervention)->id_costumer;
            $user_id  = Interevention::findOrFail($intervention)->user_id;
            $vehicule_id = DB::table('vehicles')->insertGetId(
                [
                    'imei' => $request->input('imei'),
                    'marque' => $request->input('marque'),
                    'model' => $request->input('model') ,
                    'costumer_id' => $costumer ,
                    'user_id' => $user_id
                ]
            );
        }

        if ($imei_boitier != null) {
            if($type == 'i') {
                DB::table('inventory_personals')
                    ->where('product_id',$imei_boitier)
                    ->update(['status' => '0']);
                DB::table('products')
                    ->where('id',$imei_boitier)
                    ->update(['status' => '0']);
            }
            else {
                if($type == 'd') {
                    DB::table('inventory_personals')
                        ->where('product_id',$imei_boitier)
                        ->update(['status' => '2']);
                    DB::table('products')
                        ->where('id',$imei_boitier)
                        ->update(['status' => '1']);
                }
            }
        }

        if($imei_carte != null) {
            if($type == 'i') {
                DB::table('inventory_personals')
                    ->where('product_id',$imei_carte)
                    ->update(['status' => '0']);
                DB::table('products')
                    ->where('id',$imei_carte)
                    ->update(['status' => '0']);
            }
            else {
                if($type == 'd') {
                    DB::table('inventory_personals')
                        ->where('product_id',$imei_carte)
                        ->update(['status' => '2']);
                    DB::table('products')
                        ->where('id',$imei_carte)
                        ->update(['status' => '1']);
                }elseif ($type == 'r'){
                    DB::table('inventory_personals')
                        ->where('product_id',$imei_carte)
                        ->update(['status' => '0']);
                    DB::table('products')
                        ->where('id',$imei_carte)
                        ->update(['status' => '0']);
                }
            }
        }

        if ($imei_boitier == null && $box_costumer == null && $type != 'cb') {
            $imei_boitier = DB::table('products')
                ->insertGetId([
                    'imei_product' => $request->input('imei_product'),
                    'model' => $request->input('model_boitier'),
                    'movement_id' => 30,
                    'status' => '0'
                ]);
        }


        if ($imei_carte == null && $sim_costumer == null  && $type != 'cs') {
            $imei_carte = DB::table('products')
                ->insertGetId([
                    'imei_product' => $request->input('ssid'),
                    'model' => $request->input('model_sim'),
                    'movement_id' => 31,
                    'label' => $request->input('numero'),
                    'state' => $request->input('etat'),
                    'status' => '0'
                ]);
        }

        $oldChange = null;

        if ($type == 'cb') {
            $old = $request->input('oldcb_box');
            if($old == '') {
                $old = DB::table('products')
                    ->insertGetId([
                        'imei_product' => $request->input('imei_product'),
                        'model' => $request->input('model_boitier'),
                        'movement_id' => 30,
                        'status' => '2'
                    ]);
                DB::table('inventory_personals')
                    ->insertGetId([
                        'personal_id' => $installateur,
                        'product_id' => $old,
                        'user_id' => 8,
                        'status' => '1'
                    ]);
            }else{
                DB::table('inventory_personals')
                    ->where('product_id',$old)
                    ->update([
                        'status' => '1',
                        'personal_id' => $installateur
                    ]);
                DB::table('products')
                    ->where('id',$old)
                    ->update(['status' => '2']);
            }

            $oldChange = $old;



            $imei_boitier = $request->input('newcb_box');
            DB::table('inventory_personals')
                ->where('product_id',$imei_boitier)
                ->update(['status' => '0']);
            DB::table('products')
                ->where('id',$imei_boitier)
                ->update(['status' => '0']);
        }

        if ($type == 'cs') {
            $old = $request->input('oldcs_sim');
            if($old == '') {
                $old = DB::table('products')
                    ->insertGetId([
                        'imei_product' => $request->input('ssid'),
                        'model' => $request->input('model_sim'),
                        'movement_id' => 31,
                        'label' => $request->input('numero'),
                        'state' => $request->input('etat'),
                        'status' => '0'
                    ]);
                DB::table('inventory_personals')
                    ->insertGetId([
                        'personal_id' => $installateur,
                        'product_id' => $old,
                        'user_id' => 8,
                        'status' => '1'
                    ]);
            }else{
                DB::table('inventory_personals')
                    ->where('product_id',$old)
                    ->update([
                        'status' => '1',
                        'personal_id' => $installateur
                    ]);
                DB::table('products')
                    ->where('id',$old)
                    ->update(['status' => '2']);
            }
            $oldChange = $old;


            $imei_carte = $request->input('newcs_sim');
            DB::table('inventory_personals')
                ->where('product_id',$imei_carte)
                ->update(['status' => '0']);
            DB::table('products')
                ->where('id',$imei_carte)
                ->update(['status' => '0']);
        }



        DB::table('details_intervention')
            ->insert(
                [
                    'id_intervention'=>$intervention,
                    'type'=>$type,
                    'id_vehicule'=>$vehicule_id,
                    'imei_boitier'=>$imei_boitier,
                    'imei_carte'=>$imei_carte,
                    'kilometrage'=>$kilometrage,
                    'remarque'=>$remarque,
                    'detail_starthour'=>$detail_starthour,
                    'detail_endhour'=>$detail_endhour,
                    'box_costumer'=>$box_costumer,
                    'sim_costumer'=>$sim_costumer,
                    'status'=>'0',
                    'oldChange' => $oldChange
                ]
            );
        return response()->json([],201);
    }


    public function getMovement($categorie){
        return DB::table('movements')
            ->where('category_id',$categorie)
            ->get();
    }


    public function getPlan($categorie){
        return DB::table('plan')
            ->where('categorie_id',$categorie)
            ->get();
    }


    public function getSim(Request $request){
        $intervention = $request->input('intervention');
        $costumer = Interevention::findOrFail($intervention)->id_costumer;
        $installateur = Interevention::findOrFail($intervention)->id_instalateur;
        $flag = $request->input('stock');

        // if flag == 0 it's mean old sim
        if($flag == 0) {
            $data = DB::table('products')
                ->where('products.status','=','0')
                ->where('interevention.id_costumer','=',$costumer)
                ->where(DB::raw("details_intervention.type in ('i','cb','cs') or (details_intervention.type in ('r','v') and products.beforeOms = '1')"))
                ->join('details_intervention','details_intervention.imei_carte','=','products.id')
                ->join('interevention','interevention.id','=','details_intervention.id_intervention')
                ->select('products.label as product_label','products.id as product_id','details_intervention.*','interevention.*')
                ->distinct()
                ->get();
        }else {
            $data = DB::table('products')
                ->where('inventory_personals.personal_id','=',$installateur)
                ->where('inventory_personals.status','=','1')
                ->where('products.status','=','2')
                ->where('categories.id','=',2)
                ->join('inventory_personals','inventory_personals.product_id','=','products.id')
                ->join('movements','movements.id','=','products.movement_id')
                ->join('categories','categories.id','=','movements.category_id')
                ->select('products.label as product_label','products.id as product_id','products.*','inventory_personals.*','movements.*','categories.*')
                ->distinct()
                ->get();
        }
        return response()->json($data,201);
    }

    public function getBox(Request $request){
        $intervention = $request->input('intervention');
        $costumer = Interevention::findOrFail($intervention)->id_costumer;
        $installateur = Interevention::findOrFail($intervention)->id_instalateur;
        $flag = $request->input('stock');

        // if flag == 0 it's mean old box
        if($flag == 0) {
            $data = DB::table('products')
                ->where('products.status','=','0')
                ->where('interevention.id_costumer','=',$costumer)
                ->where(DB::raw("details_intervention.type in ('i','cb','cs') or (details_intervention.type in ('r','v') and products.beforeOms = '1')"))
                ->join('details_intervention','details_intervention.imei_boitier','=','products.id')
                ->join('interevention','interevention.id','=','details_intervention.id_intervention')
                ->select('products.label as product_label','products.id as product_id','products.*','details_intervention.*','interevention.*')
                ->distinct()
                ->get();
        }else {
            $data = DB::table('products')
                ->where('inventory_personals.personal_id','=',$installateur)
                ->where('inventory_personals.status','=','1')
                ->where('products.status','=','2')
                ->where('categories.id','=',1)
                ->join('inventory_personals','inventory_personals.product_id','=','products.id')
                ->join('movements','movements.id','=','products.movement_id')
                ->join('categories','categories.id','=','movements.category_id')
                ->select('products.label as product_label','products.id as product_id','products.*','inventory_personals.*','movements.*','categories.*')
                ->distinct()
                ->get();
        }
        return response()->json($data,201);
    }

}
