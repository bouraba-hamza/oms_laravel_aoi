<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LigneFactureClient extends Model
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
