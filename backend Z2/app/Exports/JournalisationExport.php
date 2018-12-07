<?php

namespace App\Exports;

use App\Journalisation;
use Maatwebsite\Excel\FromCollection;

class JournalisationExport implements FromCollection
{
    public function collection()
    {
        return Journalisation::all();
    }
}