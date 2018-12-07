<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReglementClient extends Model
{
    protected $fillable = [
        'Montant',
        'DateReglement',
        'NumCheque',
        'Banque',
        'ModePaiement',
        'DateEcheance',
        'FactureID',
        'BanqueID'

    ];
}
