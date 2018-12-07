<?php

namespace App\Http\Controllers\Personaldetail;
use DateTime;
use App\Http\Controllers\Controller;
use App\Models\Personaldetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests;
use Storage;

class PersonalDetailsController extends Controller
{
    public function index(Request $request)
    {
        $datapersonal = DB::table('details_personal')->get();


        return $datapersonal;
    }

    public function indexService(Request $request)
    {
        return Personaldetail::all();
    }

    public function create(Request $request)
    {
        Personaldetail::create();
    }


    public function getDetailPersonal(Request $request){
        $intervention = intval($request->input('id'));
        $dataInterventions = DB::table('details_personal')
            ->where('details_personal.id','=',$intervention)
            ->join('list_box_view','list_box_view.id','=','details_personal.id')
            ->join('list_card_view','list_card_view.id','=','details_personal.id')
            ->select('details_personal.imei_boitier','details_personal.date_products','details_personal.label','details_personal.date_label','details_personal.id_personal','list_box_view.*','list_card_view.*')
            ->get();

        return response()->json($dataInterventions, 201);
    }



}




