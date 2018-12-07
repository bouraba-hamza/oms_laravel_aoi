<?php

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;



/**
 * Class SchemaVehicule
 *
 * @property int $id
 * @property int $marque_id
 * @property int $modele_id
 * @property int $modelyear
 * @property string $image
 *
 *
 * @package App\Models
 */

class SchemaVehicule extends Eloquent
{
    protected $table = 'shemavehicle';
    public $timestamps = false;

    protected $casts = [
        'modelyear' => 'int'
    ];

    protected $fillable = [
        'marque_id',
        'modele_id',
        'modelyear',
        'image'
    ];
}