<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DevisClient extends Model
{
    protected $fillable = [

        'MontantHT',
        'MontantTVA',
        'MontantTTC',
        'NotePublic',
        'NotePriver',
        'EtatFacture',
        'DateEcheance',
        'DateFacture',
        'MontantReglement',
        'ClientID'
    ];
}
