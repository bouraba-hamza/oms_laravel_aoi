<?php

namespace App\Http\Controllers\provider;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class ProviderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataprovider = DB::table('providers')
            ->join('types_providers', 'types_providers.id', '=', 'providers.types_providers_id')
            ->select('providers.id as id_provider','providers.*','types_providers.*')
            ->get();

        return $dataprovider;

    }

    public function indexByIdCategorie($idCatgorie)
    {

        return Provider::where('categorie_id','=',$idCatgorie)->get();

    }



    public function indexService(Request $request){
        return Provider::all();
    }

    public function create(Request $request)
    {
        Provider::create();
    }


    public function store(Request $request)
    {

        if($provider = Provider::create($request->all()))
        {
            return response()->json($provider, 201);
        }else
            return response()->json(['data'=>'error in the insert'], 500);

    }

    public function update(Request $request)
    {

        $providerUpdate = Provider::findOrFail($request->input('id'));
        if($provider = $providerUpdate->update($request->all()))
        {
            return response()->json($provider, 201);
        }else
            return response()->json(['data'=>'error in the update'], 500);
    }


    public function destroy($idProvider)
    {

        log::info($idProvider);
        if ($provider= Provider::find($idProvider)) {
            $provider->delete();
            return response()->json(null, 202);
        } else
            return response()->json(['data' => 'error in the delete'], 500);
    }
}

