<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 28 Jan 2018 11:07:32 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Vehicle
 * 
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $matricule
 * @property string $marque
 * @property string $model
 * @property int $costumer_id
 * @property int $created_by
 * 
 * @property \App\Models\Costumer $costumer
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $interventiondetails
 *
 * @package App\Models
 */
class Vehicle extends Eloquent
{
    protected $table = 'vehicles';

    protected $casts = [
        'costumer_id' => 'int',
        'user_id' => 'int',
        'isActive' => 'int'
    ];

    protected $dates = [
        'date_expiration'
    ];

    protected $fillable = [
        'imei',
        'model',
        'marque',
        'costumer_id',
        'user_id',
        'statuts',
        'type_boitier',
        'imei_product',
        'date_expiration',
        'isActive'
    ];
}
