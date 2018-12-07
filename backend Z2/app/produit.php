<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class produit extends Model
{
    protected $fillable = [
'RefProduit',
'NomProduit',
'DescriptionProduit',
'DescriptionFacture',
'PrixVente',
'PrixVenteMin',
'TauxTVA',
'TypeProduit',
'type',
'EtatVente',
'EtatAchat'   ];

}
