<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LigneFactureIntervention extends Model
{
    protected $fillable = [
    'Reducation',
    'DetailInterventionID',
    'FactureID',
    'StartDateSIM',
    'EndDateSIM',
    'PUHT',
    'TVA',
    'DescriptionFactureLigne',
    'PrixParMois',
    ];
}
