<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 12 Jul 2018 12:13:25 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Costumer
 *
 * @property int $id
 * @property string $name
 * @property string $contact
 * @property int $type_id
 * @property string $phone_number
 * @property string $mail
 * @property string $city
 * @property string $departement
 * @property string $adress
 * @property string $user_id
 * @property string $date_debut_contrat
 * @property string $api_key
 * @property int $nombre_appel
 * @property string $codepostal
 * @property string $region
 *@property \Carbon\Carbon $created_at
 *@property \Carbon\Carbon $updated_at
 *

 * @package App\Models
 */
class Costumer extends Eloquent
{

    protected $table = 'costumers';

    protected $casts = [
        'disabled' => 'int'
    ];


    protected $fillable = [
        'name',
        'contact',
        'type_id',
        'phone_number',
        'mail',
        'city',
        'departement',
        'adress',
        'user_id',
        'date_debut_contrat',
        'api_key',
        'nombre_appel',
        'codepostal',
        'region'


    ];


}
