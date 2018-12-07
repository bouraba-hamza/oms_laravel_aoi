<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banque extends Model
{
    protected $fillable = [

        'RefCompte',
        'Type',
        'Devis',
        'Domiciliation',
        'Nom',
        'Numero',
        'Proprietaire',
        'Solde',
    ];
}
