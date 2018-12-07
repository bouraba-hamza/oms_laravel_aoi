<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LigneDevisClient extends Model
{
    protected $fillable = [
        'TVA',
        'PUHT',
        'Qte',
        'Reducation',
        'ProduitsID',
        'FactureID'
    ];
}
