<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReglementProvider extends Model
{

    protected $fillable = [
        'Montant',
        'DateReglement',
        'NumCheque',
        'Banque',
        'ModePaiement',
        'FactureID'

    ];
}
