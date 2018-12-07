<?php

namespace App\Http\Controllers\SchemaVehicule;
use DateTime;
use App\Http\Controllers\Controller;
use App\Models\SchemaVehicule;
use App\Services\SchemaVehiculeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests;
use Storage;

class SchemaController extends Controller
{
    public function index(Request $request)
    {
        $dataschema = DB::table('shemavehicle')
            ->join('modele', 'modele.id', '=', 'shemavehicle.modele_id')
            ->join('marque', 'marque.id', '=', 'shemavehicle.marque_id')
            ->select('shemavehicle.*', 'modele.modele', 'marque.marque')
            ->get();


        return $dataschema;
    }

    public function indexService(Request $request)
    {
        return SchemaVehicule::all();
    }

    public function create(Request $request)
    {
        SchemaVehicule::create();
    }


    public function store(Request $request)
    {
        Log::info($request);
        Log::info($request->all());
        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $image = $file->getClientOriginalName();
            $fake_name = 'schema_' . $image;
            $path = $request->file('photo')->storeAs(
                'images', $fake_name
            );
            log::info($path);


        }

        $marque_id = $request->input('marque_id');
        $modele_id = $request->input('modele_id');
        $modelyear = $request->input('modelyear');

        if ($schemavehicule = SchemaVehicule::create(['marque_id' => $marque_id, 'modele_id' => $modele_id, 'modelyear' => $modelyear, 'image' => $fake_name])) {
            return response()->json($schemavehicule, 201);
        } else
            return response()->json(['data' => 'error in the insert'], 500);


    }


    public function show(SchemaVehicule $schemavehicule)
    {

    }


    public function edit(SchemaVehicule $schemavehicule)
    {

    }


    public function update(Request $request)
    {
        Log::info($request);

        Log::info($request->all());


        if ($request->hasFile('photo')) {
            $file = $request->photo;
            $image = $file->getClientOriginalName();
            $fake_name = 'schema_' . $image;
            $path = $request->file('photo')->storeAs(
                'images', $fake_name
            );
            log::info($path);


        }

        $marque_id = $request->input('marque_id');
        $modele_id = $request->input('modele_id');
        $modelyear = $request->input('modelyear');

        $schemavehiculeUpdate = SchemaVehicule::findOrFail($request->input('id'));


        if (isset($fake_name) && !empty($fake_name)) {
            $schemavehicule = $schemavehiculeUpdate->update(['marque_id' => $marque_id, 'modele_id' => $modele_id, 'modelyear' => $modelyear, 'image' => $fake_name]);
            return response()->json($schemavehicule, 201);
        } else {


            if ($schemavehicule = $schemavehiculeUpdate->update(['marque_id' => $marque_id, 'modele_id' => $modele_id, 'modelyear' => $modelyear])) {
                log::info($schemavehicule);
                return response()->json($schemavehicule, 201);
            } else
                return response()->json(['data' => 'error in the update'], 500);
        }

    }


    public function destroy($idSchemaVehicule)
    {



        if ($schemavehicule = SchemaVehicule::find($idSchemaVehicule)) {
            $schemavehicule->delete();
            return response()->json(null, 202);
        } else
            return response()->json(['data' => 'error in the delete'], 500);
    }




}




