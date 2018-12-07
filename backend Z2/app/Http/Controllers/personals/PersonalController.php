<?php

namespace App\Http\Controllers\personals ;

use App\Http\Controllers\Controller;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PersonalController extends Controller
{


    public function index(Request $request)
    {

        $datapersonal = DB::table('stock_personnel_test')->get();
        return $datapersonal;

    }

    public function indexIntervention($id)
    {
        $interventions = DB::table(
            'interevention i',
            "id_instalateur=${id} and i.status='En cours'",
            ['fields' => '*']
        );

        return count($interventions);
    }


    public function getDetailPersonal(Request $request){
        $personal = intval($request->input('id'));
        $dataPersonal = DB::table('details_personal')
            ->where('details_personal.id','=',$personal)
            ->join('personals','personals.id','=','details_personal.personal_id')
            ->join('list_box_view','list_box_view.id','=','details_personal.id')
            ->join('list_card_view','list_card_view.id','=','details_personal.id')
            ->select('details_personal.imei_product','details_personal.date_product','details_personal.label','details_personal.date_label','details_personal.personal_id','list_box_view.*','list_card_view.*','personals.*')
            ->get();

        return response()->json($dataPersonal, 201);
    }
}
