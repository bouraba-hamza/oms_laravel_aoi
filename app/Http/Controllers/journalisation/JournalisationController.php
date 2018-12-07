<?php

namespace App\Http\Controllers\journalisation ;

use App\Http\Controllers\Controller;
use App\Models\Journalisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\JournalisationExport;
use Maatwebsite\Excel\Facades\Excel;

class JournalisationController extends Controller
{
    public function index()
    {
        $datajournalisation = DB::table('journalisation')
            ->get();


        return $datajournalisation;
    }

    public function indexService(Request $request)
    {
        return Journalisation::all();
    }

   public function export()
    {
        return Excel::download(new JournalisationExport, 'journalisation.xlsx');
    }

}




