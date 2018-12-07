<?php

namespace App\Http\Controllers\plan;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Movement;
use Illuminate\Support\Facades\DB;


class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index( $idCatgorie)
    {
        return   Plan::where('categorie_id','=',$idCatgorie)->get();
    }

    public function store(Request $request)
    {
        log::info($request );
        if($movement = plan::create($request->all()))
        {

            return response()->json($movement, 201);
        }
        else
            return response()->json(['data'=>'error in the insert'], 500);



    }
}

