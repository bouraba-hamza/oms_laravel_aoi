<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FactureDetailIntervention extends Model
{

    protected $fillable = [
        'type',
        'id_vehicule',
        'imei_boitier',
        'imei_carte',
        'id_intervention',
        'kilometrage',
        'remarque',
        'box_costumer',
        'sim_costumer',
        'status',
        'EtatFacturation',

    ];


}
