<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FactureProvider extends Model
{
    protected $fillable = [
        'RefFacture',
        'MontantHT',
        'MontantTVA',
        'MontantTTC',
        'NotePublic',
        'NotePriver',
        'EtatFacture',
        'DateEcheance',
        'DateFacture',
        'MontantReglement',
        'MovementID',
        'ProviderID'
    ];
}
